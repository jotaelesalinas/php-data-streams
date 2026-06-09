<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Core;

interface Reader extends \IteratorAggregate
{
    public function getIterator(): \Traversable;
}
