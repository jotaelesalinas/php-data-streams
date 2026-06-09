<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Csv\CsvReader;
use JLSalinas\DataStreams\Csv\CsvWriter;
use PHPUnit\Framework\TestCase;

final class TsvReaderWriterTest extends TestCase
{
    public function testTsvNamedConstructorsWork(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'tsv');
        $writer = CsvWriter::fromTsv($file);

        $writer->write(['name' => 'Ada', 'age' => '37']);
        $writer->close();

        self::assertSame([
            ['name' => 'Ada', 'age' => '37'],
        ], iterator_to_array(CsvReader::fromTsv($file)));
    }
}
