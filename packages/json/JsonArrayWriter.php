<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Json;

use JLSalinas\DataStreams\Core\Writer;

final class JsonArrayWriter implements Writer
{
    private $handle;

    private bool $started = false;

    private bool $hasItems = false;

    public function __construct(private readonly string $filename)
    {
    }

    public function write(mixed $record): void
    {
        $handle = $this->handle ??= fopen($this->filename, 'wb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open output file: ' . $this->filename);
        }

        if (! $this->started) {
            fwrite($handle, '[' . PHP_EOL);
            $this->started = true;
        }

        $encoded = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        if ($this->hasItems) {
            fwrite($handle, ',' . PHP_EOL);
        }

        fwrite($handle, $encoded);
        $this->hasItems = true;
    }

    public function close(): void
    {
        if (! $this->started) {
            $handle = $this->handle ??= fopen($this->filename, 'wb');
            if ($handle === false) {
                throw new \RuntimeException('Could not open output file: ' . $this->filename);
            }

            fwrite($handle, '[]' . PHP_EOL);
            $this->started = true;
            $this->hasItems = false;
        } elseif (is_resource($this->handle)) {
            fwrite($this->handle, PHP_EOL . ']' . PHP_EOL);
        }

        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }
}
