<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Xml\XmlReader;
use JLSalinas\DataStreams\Xml\XmlWriter;
use PHPUnit\Framework\TestCase;

final class XmlTest extends TestCase
{
    public function testXmlReaderAndWriterRoundTrip(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'xml');
        $writer = new XmlWriter($file, 'customers', 'customer');

        $writer->write(['name' => 'Ada', 'age' => '37']);
        $writer->write(['name' => 'Bob', 'age' => '41']);
        $writer->close();

        self::assertSame([
            ['name' => 'Ada', 'age' => '37'],
            ['name' => 'Bob', 'age' => '41'],
        ], iterator_to_array(new XmlReader($file, 'customer')));
    }
}
