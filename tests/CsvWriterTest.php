<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Csv\CsvWriter;
use PHPUnit\Framework\TestCase;

final class CsvWriterTest extends TestCase
{
    public function testWritesHeaderAndRows(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'csv');
        $writer = new CsvWriter($file);

        $writer->write(['name' => 'Ada', 'age' => '37']);
        $writer->write(['name' => 'Bob', 'age' => '41']);
        $writer->close();

        self::assertSame(
            "name,age\nAda,37\nBob,41\n",
            file_get_contents($file)
        );
    }
}
