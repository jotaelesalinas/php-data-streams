<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Json;

use JLSalinas\DataStreams\Core\Reader;

final class JsonLinesReader implements Reader
{
    public function __construct(private readonly string $filename)
    {
    }

    public function getIterator(): \Traversable
    {
        $handle = fopen($this->filename, 'rb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open input file: ' . $this->filename);
        }

        try {
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }

                yield json_decode($line, true, 512, JSON_THROW_ON_ERROR);
            }
        } finally {
            fclose($handle);
        }
    }
}
