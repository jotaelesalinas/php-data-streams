<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Csv\CsvReader;
use PHPUnit\Framework\TestCase;

final class CsvReaderTest extends TestCase
{
    public function testReadsRowsWithHeaders(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($file, "name,age\nAda,37\nBob,41\n");

        $rows = iterator_to_array(new CsvReader($file));

        self::assertSame([
            ['name' => 'Ada', 'age' => '37'],
            ['name' => 'Bob', 'age' => '41'],
        ], $rows);
    }
}
