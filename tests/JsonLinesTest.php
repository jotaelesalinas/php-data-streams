<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Json\JsonLinesReader;
use JLSalinas\DataStreams\Json\JsonLinesWriter;

it('round trips json lines', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'jsonl');
    $writer = new JsonLinesWriter($file);

    $writer->write(['name' => 'Ada']);
    $writer->write(['name' => 'Bob']);
    $writer->close();

    expect(iterator_to_array(new JsonLinesReader($file)))->toBe([
        ['name' => 'Ada'],
        ['name' => 'Bob'],
    ]);
});
