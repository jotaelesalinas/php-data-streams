<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Http;

use JLSalinas\DataStreams\Core\Reader;

final class HttpLinesReader implements Reader
{
    /**
     * @param iterable<string> $lines
     */
    public function __construct(private readonly iterable $lines)
    {
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->lines as $line) {
            $line = trim((string) $line);
            if ($line === '') {
                continue;
            }

            yield $line;
        }
    }
}
