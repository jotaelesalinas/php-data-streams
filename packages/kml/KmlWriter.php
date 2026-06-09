<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Kml;

use JLSalinas\DataStreams\Core\Writer;
use JLSalinas\DataStreams\Xml\XmlWriter;

final class KmlWriter implements Writer
{
    private XmlWriter $writer;

    public function __construct(private readonly string $filename)
    {
        $this->writer = new XmlWriter($this->filename, 'kml', 'Placemark');
    }

    public function write(mixed $record): void
    {
        if (!is_array($record)) {
            throw new \InvalidArgumentException('KML writer expects associative arrays.');
        }

        $this->writer->write($record);
    }

    public function close(): void
    {
        $this->writer->close();
    }
}
