<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Xml\XmlReader;
use JLSalinas\DataStreams\Xml\XmlWriter;

it('round trips xml', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'xml');
    $writer = new XmlWriter($file, 'customers', 'customer');

    $writer->write(['name' => 'Ada', 'age' => '37']);
    $writer->write(['name' => 'Bob', 'age' => '41']);
    $writer->close();

    expect(iterator_to_array(new XmlReader($file, 'customer')))->toBe([
        ['name' => 'Ada', 'age' => '37'],
        ['name' => 'Bob', 'age' => '41'],
    ]);
});
