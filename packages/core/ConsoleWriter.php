<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Core;

final class ConsoleWriter implements Writer
{
    private $output;

    public function __construct($output = null)
    {
        $this->output = $output;
    }

    public function write(mixed $record): void
    {
        $stream = $this->output ?? fopen('php://stdout', 'wb');
        fwrite($stream, $this->format($record) . PHP_EOL);
    }

    public function close(): void
    {
    }

    private function format(mixed $record): string
    {
        if (is_scalar($record) || $record === null) {
            return (string) $record;
        }

        return json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
    }
}
