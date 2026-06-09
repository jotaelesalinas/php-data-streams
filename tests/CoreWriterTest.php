<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Core\ConsoleWriter;
use PHPUnit\Framework\TestCase;

final class CoreWriterTest extends TestCase
{
    public function testFormatsArraysAsJson(): void
    {
        $stream = fopen('php://temp', 'wb+');
        $writer = new ConsoleWriter($stream);

        $writer->write(['name' => 'Ada']);

        rewind($stream);
        self::assertSame('{"name":"Ada"}' . PHP_EOL, stream_get_contents($stream));
    }
}
