<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Csv\CsvReader;
use JLSalinas\DataStreams\Csv\CsvWriter;

it('supports named constructors for tsv', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'tsv');
    $writer = CsvWriter::fromTsv($file);

    $writer->write(['name' => 'Ada', 'age' => '37']);
    $writer->close();

    expect(iterator_to_array(CsvReader::fromTsv($file)))->toBe([
        ['name' => 'Ada', 'age' => '37'],
    ]);
});
