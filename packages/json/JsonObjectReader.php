<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Json;

use JLSalinas\DataStreams\Core\Reader;

final class JsonObjectReader implements Reader
{
    public function __construct(private readonly string $filename)
    {
    }

    public function getIterator(): \Traversable
    {
        yield from (new JsonIncrementalParser)->readObject($this->filename);
    }
}
