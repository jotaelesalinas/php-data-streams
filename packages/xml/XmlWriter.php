<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Xml;

use JLSalinas\DataStreams\Core\Writer;

final class XmlWriter implements Writer
{
    private ?\XMLWriter $writer = null;
    private bool $rootOpened = false;

    public function __construct(
        private readonly string $filename,
        private readonly string $rootElement = 'items',
        private readonly string $recordElement = 'item'
    ) {
    }

    public function write(mixed $record): void
    {
        if (!is_array($record)) {
            throw new \InvalidArgumentException('XML writer expects associative arrays.');
        }

        $writer = $this->writer ??= new \XMLWriter();
        if (!$this->rootOpened) {
            if (!$writer->openUri($this->filename)) {
                throw new \RuntimeException('Could not open XML file: ' . $this->filename);
            }

            $writer->startDocument('1.0', 'UTF-8');
            $writer->startElement($this->rootElement);
            $this->rootOpened = true;
        }

        $writer->startElement($this->recordElement);
        foreach ($record as $key => $value) {
            $writer->writeElement((string) $key, (string) $value);
        }
        $writer->endElement();
    }

    public function close(): void
    {
        if ($this->writer instanceof \XMLWriter) {
            if ($this->rootOpened) {
                $this->writer->endElement();
                $this->writer->endDocument();
            }
            $this->writer->flush();
        }
    }
}
