<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Csv\CsvReader;

it('keeps csv reader memory flat', function (): void {
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
        expect($row)->toHaveKey('id');
    }

    $end = memory_get_usage(true);

    expect($count)->toBe(5000);
    expect($end - $start)->toBeLessThan(2 * 1024 * 1024);
});
