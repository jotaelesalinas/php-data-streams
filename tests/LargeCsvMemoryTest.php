<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Csv\CsvReader;
use PHPUnit\Framework\TestCase;

final class LargeCsvMemoryTest extends TestCase
{
    public function testCsvReaderKeepsMemoryFlat(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'csv');
        $handle = fopen($file, 'wb');
        fwrite($handle, "id,name\n");

        for ($i = 1; $i <= 5000; $i++) {
            fwrite($handle, $i . ',Name' . $i . "\n");
        }

        fclose($handle);

        $start = memory_get_usage(true);
        $count = 0;

        foreach (new CsvReader($file) as $row) {
            $count++;
            self::assertArrayHasKey('id', $row);
        }

        $end = memory_get_usage(true);

        self::assertSame(5000, $count);
        self::assertLessThan(2 * 1024 * 1024, $end - $start);
    }
}
