<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Csv;

use JLSalinas\DataStreams\Core\Writer;

final class CsvWriter implements Writer
{
    private $handle;
    private bool $headerWritten = false;

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

        $handle = $this->handle ??= fopen($this->filename, 'wb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open output file: ' . $this->filename);
        }

        if ($this->withHeaders && !$this->headerWritten) {
            fputcsv($handle, array_keys($record), $this->separator, $this->enclosure, $this->escape);
            $this->headerWritten = true;
        }

        fputcsv($handle, array_values($record), $this->separator, $this->enclosure, $this->escape);
    }

    public function close(): void
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }
}
