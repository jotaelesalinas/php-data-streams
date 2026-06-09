<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Json;

use JLSalinas\DataStreams\Core\Writer;

final class JsonObjectWriter implements Writer
{
    private $handle;

    private bool $started = false;

    private bool $hasItems = false;

    public function __construct(private readonly string $filename)
    {
    }

    public function write(mixed $record): void
    {
        if (! is_array($record) || ! array_is_list($record) || count($record) !== 2) {
            throw new \InvalidArgumentException('JsonObjectWriter expects a [key, value] pair.');
        }

        $handle = $this->handle ??= fopen($this->filename, 'wb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open output file: ' . $this->filename);
        }

        if (! $this->started) {
            fwrite($handle, '{' . PHP_EOL);
            $this->started = true;
        }

        [$key, $value] = $record;
        $encodedKey = json_encode((string) $key, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        $encodedValue = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

        if ($this->hasItems) {
            fwrite($handle, ',' . PHP_EOL);
        }

        fwrite($handle, $encodedKey . ': ' . $encodedValue);
        $this->hasItems = true;
    }

    public function close(): void
    {
        if (! $this->started) {
            $handle = $this->handle ??= fopen($this->filename, 'wb');
            if ($handle === false) {
                throw new \RuntimeException('Could not open output file: ' . $this->filename);
            }

            fwrite($handle, '{}' . PHP_EOL);
            $this->started = true;
            $this->hasItems = false;
        } elseif (is_resource($this->handle)) {
            fwrite($this->handle, PHP_EOL . '}' . PHP_EOL);
        }

        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }
}
