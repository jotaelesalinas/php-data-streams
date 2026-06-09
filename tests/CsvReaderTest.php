<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Csv\CsvReader;

it('reads rows with headers', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'csv');
    file_put_contents($file, "name,age\nAda,37\nBob,41\n");

    expect(iterator_to_array(new CsvReader($file)))->toBe([
        ['name' => 'Ada', 'age' => '37'],
        ['name' => 'Bob', 'age' => '41'],
    ]);
});
