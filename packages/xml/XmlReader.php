<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Xml;

use JLSalinas\DataStreams\Core\Reader;

final class XmlReader implements Reader
{
    public function __construct(
        private readonly string $filename,
        private readonly string $recordElement
    ) {
    }

    public function getIterator(): \Traversable
    {
        $reader = new \XMLReader();
        if (!$reader->open($this->filename)) {
            throw new \RuntimeException('Could not open XML file: ' . $this->filename);
        }

        try {
            while ($reader->read()) {
                if ($reader->nodeType !== \XMLReader::ELEMENT || $reader->name !== $this->recordElement) {
                    continue;
                }

                $node = new \SimpleXMLElement($reader->readOuterXML());
                yield json_decode(json_encode($node, JSON_THROW_ON_ERROR) ?: '[]', true, 512, JSON_THROW_ON_ERROR);
            }
        } finally {
            $reader->close();
        }
    }
}
