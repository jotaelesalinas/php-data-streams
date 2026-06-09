<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Csv\CsvWriter;

it('writes header and rows', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'csv');
    $writer = new CsvWriter($file);

    $writer->write(['name' => 'Ada', 'age' => '37']);
    $writer->write(['name' => 'Bob', 'age' => '41']);
    $writer->close();

    expect(file_get_contents($file))->toBe("name,age\nAda,37\nBob,41\n");
});
