<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Json;

final class JsonIncrementalParser
{
    private const CHUNK_SIZE = 4096;

    /**
     * @return \Generator<mixed>
     */
    public function readArray(string $filename): \Generator
    {
        $handle = fopen($filename, 'rb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open input file: ' . $filename);
        }

        try {
            yield from $this->parseArray($handle);
        } finally {
            fclose($handle);
        }
    }

    /**
     * @return \Generator<string, mixed>
     */
    public function readObject(string $filename): \Generator
    {
        $handle = fopen($filename, 'rb');
        if ($handle === false) {
            throw new \RuntimeException('Could not open input file: ' . $filename);
        }

        try {
            yield from $this->parseObject($handle);
        } finally {
            fclose($handle);
        }
    }

    private function parseArray($handle): \Generator
    {
        $state = new JsonStreamState;
        $state->expectRoot('[');

        foreach ($this->chars($handle) as $char) {
            if (! $state->started) {
                if ($this->isWhitespace($char)) {
                    continue;
                }

                $state->started = true;
                if ($char !== '[') {
                    throw new \RuntimeException('Expected JSON array root.');
                }

                continue;
            }

            if ($state->finished) {
                if (! $this->isWhitespace($char)) {
                    throw new \RuntimeException('Unexpected data after JSON array root.');
                }

                continue;
            }

            if ($state->inString) {
                $state->buffer .= $char;
                if ($state->escaped) {
                    $state->escaped = false;
                    continue;
                }

                if ($char === '\\') {
                    $state->escaped = true;
                    continue;
                }

                if ($char === '"') {
                    $state->inString = false;
                }

                continue;
            }

            if ($this->isWhitespace($char) && $state->buffer === '') {
                continue;
            }

            if ($char === '"') {
                $state->inString = true;
                $state->buffer .= $char;
                continue;
            }

            if ($char === '[' || $char === '{') {
                $state->depth++;
                $state->buffer .= $char;
                continue;
            }

            if (($char === ']' || $char === '}') && $state->depth > 0) {
                $state->depth--;
                $state->buffer .= $char;
                continue;
            }

            if ($char === ',' && $state->depth === 0) {
                $value = $this->decodeValue($state->buffer, 'array');
                $state->buffer = '';
                yield $value;
                continue;
            }

            if ($char === ']' && $state->depth === 0) {
                if (trim($state->buffer) !== '') {
                    yield $this->decodeValue($state->buffer, 'array');
                }

                $state->finished = true;
                $state->buffer = '';
                continue;
            }

            $state->buffer .= $char;
        }

        if (! $state->started) {
            throw new \RuntimeException('Empty file or missing JSON array root.');
        }

        if (! $state->finished) {
            throw new \RuntimeException('Unterminated JSON array.');
        }
    }

    private function parseObject($handle): \Generator
    {
        $state = new JsonStreamState;
        $state->expectRoot('{');
        $readingKey = false;
        $readingValue = false;
        $expectColon = false;
        $currentKey = null;

        foreach ($this->chars($handle) as $char) {
            if (! $state->started) {
                if ($this->isWhitespace($char)) {
                    continue;
                }

                $state->started = true;
                if ($char !== '{') {
                    throw new \RuntimeException('Expected JSON object root.');
                }

                continue;
            }

            if ($state->finished) {
                if (! $this->isWhitespace($char)) {
                    throw new \RuntimeException('Unexpected data after JSON object root.');
                }

                continue;
            }

            if ($readingKey) {
                $state->buffer .= $char;
                if ($state->escaped) {
                    $state->escaped = false;
                    continue;
                }

                if ($char === '\\') {
                    $state->escaped = true;
                    continue;
                }

                if ($char === '"') {
                    $readingKey = false;
                    $expectColon = true;
                    $currentKey = json_decode($state->buffer, true, 512, JSON_THROW_ON_ERROR);
                    $state->buffer = '';
                }

                continue;
            }

            if ($readingValue) {
                if ($state->inString) {
                    $state->buffer .= $char;
                    if ($state->escaped) {
                        $state->escaped = false;
                        continue;
                    }

                    if ($char === '\\') {
                        $state->escaped = true;
                        continue;
                    }

                    if ($char === '"') {
                        $state->inString = false;
                    }

                    continue;
                }

                if ($this->isWhitespace($char) && $state->buffer === '') {
                    continue;
                }

                if ($char === '"') {
                    $state->inString = true;
                    $state->buffer .= $char;
                    continue;
                }

                if ($char === '[' || $char === '{') {
                    $state->depth++;
                    $state->buffer .= $char;
                    continue;
                }

                if (($char === ']' || $char === '}') && $state->depth > 0) {
                    $state->depth--;
                    $state->buffer .= $char;
                    continue;
                }

                if ($char === ',' && $state->depth === 0) {
                    if ($currentKey === null) {
                        throw new \RuntimeException('Missing object key.');
                    }

                    yield $currentKey => $this->decodeValue($state->buffer, 'object value');
                    $state->buffer = '';
                    $readingValue = false;
                    $currentKey = null;
                    continue;
                }

                if ($char === '}' && $state->depth === 0) {
                    if ($currentKey === null) {
                        throw new \RuntimeException('Missing object key.');
                    }

                    yield $currentKey => $this->decodeValue($state->buffer, 'object value');
                    $state->buffer = '';
                    $readingValue = false;
                    $currentKey = null;
                    $state->finished = true;
                    continue;
                }

                $state->buffer .= $char;
                continue;
            }

            if ($expectColon) {
                if ($this->isWhitespace($char)) {
                    continue;
                }

                if ($char !== ':') {
                    throw new \RuntimeException('Expected colon after JSON object key.');
                }

                $expectColon = false;
                $readingValue = true;
                $state->buffer = '';
                continue;
            }

            if ($this->isWhitespace($char)) {
                continue;
            }

            if ($char === '}') {
                $state->finished = true;
                continue;
            }

            if ($char !== '"') {
                throw new \RuntimeException('Expected JSON object key.');
            }

            $readingKey = true;
            $state->buffer = '"';
            $state->escaped = false;
            continue;
        }

        if (! $state->started) {
            throw new \RuntimeException('Empty file or missing JSON object root.');
        }

        if (! $state->finished) {
            throw new \RuntimeException('Unterminated JSON object.');
        }
    }

    /**
     * @return \Generator<int, string>
     */
    private function chars($handle): \Generator
    {
        while (! feof($handle)) {
            $chunk = fread($handle, self::CHUNK_SIZE);
            if ($chunk === false) {
                throw new \RuntimeException('Could not read input stream.');
            }

            $length = strlen($chunk);
            for ($i = 0; $i < $length; $i++) {
                yield $chunk[$i];
            }
        }
    }

    private function decodeValue(string $buffer, string $context): mixed
    {
        $trimmed = trim($buffer);
        if ($trimmed === '') {
            throw new \RuntimeException('Empty JSON value in ' . $context . '.');
        }

        return json_decode($trimmed, true, 512, JSON_THROW_ON_ERROR);
    }

    private function isWhitespace(string $char): bool
    {
        return $char === ' ' || $char === "\n" || $char === "\r" || $char === "\t";
    }
}

final class JsonStreamState
{
    public bool $started = false;

    public bool $finished = false;

    public bool $inString = false;

    public bool $escaped = false;

    public int $depth = 0;

    public string $buffer = '';

    public function expectRoot(string $root): void
    {
        // Marker for intent; validation happens while parsing.
    }
}
