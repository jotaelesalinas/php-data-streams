<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Excel;

use JLSalinas\DataStreams\Core\Reader;
use ZipArchive;

final class XlsxReader implements Reader
{
    public function __construct(
        private readonly string $filename,
        private readonly string|int $sheet = 1
    ) {
    }

    public function getIterator(): \Traversable
    {
        $zip = new ZipArchive();
        if ($zip->open($this->filename) !== true) {
            throw new \RuntimeException('Could not open xlsx file: ' . $this->filename);
        }

        try {
            $sheetPath = $this->resolveSheetPath($zip);
            $sharedStrings = $this->readSharedStrings($zip);
            $xml = $zip->getFromName($sheetPath);
            if ($xml === false) {
                throw new \RuntimeException('Could not read sheet: ' . $sheetPath);
            }

            $sheetXml = simplexml_load_string($xml);
            if ($sheetXml === false) {
                throw new \RuntimeException('Invalid sheet XML');
            }

            foreach ($sheetXml->sheetData->row as $row) {
                $values = [];
                foreach ($row->c as $cell) {
                    $ref = (string) $cell['r'];
                    $column = preg_replace('/\d+/', '', $ref);
                    $values[(string) $column] = $this->cellValue($cell, $sharedStrings);
                }

                yield $values;
            }
        } finally {
            $zip->close();
        }
    }

    private function resolveSheetPath(ZipArchive $zip): string
    {
        $sheetNumber = is_int($this->sheet) ? $this->sheet : (int) $this->sheet;
        $path = 'xl/worksheets/sheet' . $sheetNumber . '.xml';
        if ($zip->locateName($path) === false) {
            throw new \RuntimeException('Sheet not found: ' . $this->sheet);
        }

        return $path;
    }

    /**
     * @return array<int, string>
     */
    private function readSharedStrings(ZipArchive $zip): array
    {
        $xml = $zip->getFromName('xl/sharedStrings.xml');
        if ($xml === false) {
            return [];
        }

        $shared = simplexml_load_string($xml);
        if ($shared === false) {
            return [];
        }

        $strings = [];
        foreach ($shared->si as $item) {
            $strings[] = (string) $item->t;
        }

        return $strings;
    }

    /**
     * @param array<int, string> $sharedStrings
     */
    private function cellValue(\SimpleXMLElement $cell, array $sharedStrings): string
    {
        $type = (string) $cell['t'];
        $value = (string) $cell->v;

        if ($type === 's') {
            return $sharedStrings[(int) $value] ?? '';
        }

        if ($type === 'inlineStr') {
            return (string) $cell->is->t;
        }

        return $value;
    }
}
