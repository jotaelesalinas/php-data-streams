<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Json;

use JLSalinas\DataStreams\Core\Writer;

final class JsonLinesWriter implements Writer
{
    private $handle;

    public function __construct(private readonly string $filename)
    {
    }

    public function write(mixed $record): void
    {
        $handle = $this->handle ??= fopen($this->filename, 'wb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open output file: ' . $this->filename);
        }

        fwrite($handle, json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . PHP_EOL);
    }

    public function close(): void
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }
}
