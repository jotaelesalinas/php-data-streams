<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Kml\KmlWriter;
use PHPUnit\Framework\TestCase;

final class KmlTest extends TestCase
{
    public function testKmlWriterUsesXmlComposition(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'kml');
        $writer = new KmlWriter($file);

        $writer->write(['name' => 'Ada', 'description' => 'Test']);
        $writer->close();

        $xml = file_get_contents($file);
        self::assertStringContainsString('<kml>', $xml);
        self::assertStringContainsString('<Placemark>', $xml);
        self::assertStringContainsString('<name>Ada</name>', $xml);
    }
}
