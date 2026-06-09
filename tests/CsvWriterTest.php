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

it('leaves missing columns empty', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'csv');
    $writer = new CsvWriter($file);

    $writer->write(['name' => 'Ada', 'age' => '37', 'city' => 'Madrid']);
    $writer->write(['name' => 'Bob', 'city' => 'Valencia']);
    $writer->close();

    expect(file_get_contents($file))->toBe("name,age,city\nAda,37,Madrid\nBob,,Valencia\n");
});

it('fails when a later row introduces new keys', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'csv');
    $writer = new CsvWriter($file);

    $writer->write(['name' => 'Ada', 'age' => '37']);

    expect(fn (): bool => $writer->write(['name' => 'Bob', 'age' => '41', 'city' => 'Valencia']))->toThrow(\InvalidArgumentException::class);
});
