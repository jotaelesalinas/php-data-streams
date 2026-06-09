<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Json\JsonLinesReader;
use JLSalinas\DataStreams\Json\JsonLinesWriter;
use PHPUnit\Framework\TestCase;

final class JsonLinesTest extends TestCase
{
    public function testRoundTripsJsonLines(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'jsonl');
        $writer = new JsonLinesWriter($file);

        $writer->write(['name' => 'Ada']);
        $writer->write(['name' => 'Bob']);
        $writer->close();

        self::assertSame([
            ['name' => 'Ada'],
            ['name' => 'Bob'],
        ], iterator_to_array(new JsonLinesReader($file)));
    }
}
