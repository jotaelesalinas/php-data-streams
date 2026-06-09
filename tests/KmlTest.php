<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Kml\KmlWriter;

it('writes kml using xml composition', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'kml');
    $writer = new KmlWriter($file);

    $writer->write(['name' => 'Ada', 'description' => 'Test']);
    $writer->close();

    $xml = file_get_contents($file);
    expect($xml)->toContain('<kml>');
    expect($xml)->toContain('<Placemark>');
    expect($xml)->toContain('<name>Ada</name>');
});
