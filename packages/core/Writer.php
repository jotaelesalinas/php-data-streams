<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Core;

interface Writer
{
    public function write(mixed $record): void;

    public function close(): void;
}
