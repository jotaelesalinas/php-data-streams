<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Json;

use JLSalinas\DataStreams\Core\Reader;

final class JsonArrayReader implements Reader
{
    public function __construct(private readonly string $filename)
    {
    }

    public function getIterator(): \Traversable
    {
        yield from (new JsonIncrementalParser)->readArray($this->filename);
    }
}
