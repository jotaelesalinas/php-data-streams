<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Http;

use JLSalinas\DataStreams\Core\Reader;

final class HttpPagesReader implements Reader
{
    /**
     * @param iterable<iterable<mixed>> $pages
     */
    public function __construct(private readonly iterable $pages)
    {
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->pages as $page) {
            foreach ($page as $record) {
                yield $record;
            }
        }
    }
}
