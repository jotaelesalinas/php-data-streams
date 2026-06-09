<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Csv;

use JLSalinas\DataStreams\Core\Writer;

final class CsvWriter implements Writer
{
    private $handle;
    private bool $headerWritten = false;
    /** @var array<int, string> */
    private array $headerKeys = [];

    public function __construct(
        private readonly string $filename,
        private readonly bool $withHeaders = true,
        private readonly string $separator = ',',
        private readonly string $enclosure = '"',
        private readonly string $escape = '\\'
    ) {
    }

    public static function fromTsv(string $filename, bool $withHeaders = true): self
    {
        return new self($filename, $withHeaders, "\t");
    }

    public function write(mixed $record): void
    {
        if (!is_array($record)) {
            throw new \InvalidArgumentException('CSV writer expects associative arrays.');
        }

        $recordKeys = array_keys($record);
        if ($this->headerKeys !== []) {
            $extraKeys = array_diff($recordKeys, $this->headerKeys);

            if ($extraKeys !== []) {
                throw new \InvalidArgumentException('CSV writer does not accept new keys after the header has been written.');
            }

            $row = [];
            foreach ($this->headerKeys as $key) {
                $row[] = array_key_exists($key, $record) ? $record[$key] : '';
            }
        }

        $handle = $this->handle ??= fopen($this->filename, 'wb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open output file: ' . $this->filename);
        }

        if ($this->withHeaders && !$this->headerWritten) {
            $this->headerKeys = $recordKeys;
            fputcsv($handle, $this->headerKeys, $this->separator, $this->enclosure, $this->escape);
            $this->headerWritten = true;
        }

        if ($this->headerKeys === []) {
            $this->headerKeys = $recordKeys;
        }

        fputcsv($handle, $this->headerKeys === $recordKeys ? array_values($record) : $row, $this->separator, $this->enclosure, $this->escape);
    }

    public function close(): void
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }
}
