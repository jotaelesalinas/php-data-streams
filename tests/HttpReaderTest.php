<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Http\HttpLinesReader;
use JLSalinas\DataStreams\Http\HttpPagesReader;
use PHPUnit\Framework\TestCase;

final class HttpReaderTest extends TestCase
{
    public function testHttpLinesReaderTrimsBlankLines(): void
    {
        $reader = new HttpLinesReader(["a", " ", "b"]);
        self::assertSame(['a', 'b'], iterator_to_array($reader));
    }

    public function testHttpPagesReaderFlattensPages(): void
    {
        $pages = [['a', 'b'], ['c']];
        self::assertSame(['a', 'b', 'c'], iterator_to_array(new HttpPagesReader($pages)));
    }
}
