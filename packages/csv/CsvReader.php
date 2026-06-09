<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Csv;

use JLSalinas\DataStreams\Core\Reader;

final class CsvReader implements Reader
{
    public function __construct(
        private readonly string $filename,
        private readonly bool $withHeaders = true,
        private readonly string $separator = ',',
        private readonly string $enclosure = '"',
        private readonly string $escape = '\\'
    ) {
    }

    public function getIterator(): \Traversable
    {
        $handle = fopen($this->filename, 'rb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open input file: ' . $this->filename);
        }

        try {
            $headers = null;
            while (($row = fgetcsv($handle, 0, $this->separator, $this->enclosure, $this->escape)) !== false) {
                if ($headers === null && $this->withHeaders) {
                    $headers = $row;
                    continue;
                }

                if ($row === [null] || $row === []) {
                    continue;
                }

                yield $headers === null ? $row : array_combine($headers, $row);
            }
        } finally {
            fclose($handle);
        }
    }
}
