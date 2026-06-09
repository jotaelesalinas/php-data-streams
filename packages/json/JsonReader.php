<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Json;

use JLSalinas\DataStreams\Core\Reader;

final class JsonReader implements Reader
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
            while (($char = fgetc($handle)) !== false) {
                if ($char === ' ' || $char === "\n" || $char === "\r" || $char === "\t") {
                    continue;
                }

                return match ($char) {
                    '[' => (new JsonArrayReader($this->filename))->getIterator(),
                    '{' => (new JsonObjectReader($this->filename))->getIterator(),
                    default => (new JsonLinesReader($this->filename))->getIterator(),
                };
            }
        } finally {
            fclose($handle);
        }

        return new \ArrayIterator([]);
    }
}
