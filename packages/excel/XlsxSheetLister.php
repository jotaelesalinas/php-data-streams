<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Excel;

use ZipArchive;

final class XlsxSheetLister
{
    /**
     * @return array<int, string>
     */
    public function listSheets(string $filename): array
    {
        $zip = new ZipArchive();
        if ($zip->open($filename) !== true) {
            throw new \RuntimeException('Could not open xlsx file: ' . $filename);
        }

        try {
            $xml = $zip->getFromName('xl/workbook.xml');
            if ($xml === false) {
                return [];
            }

            $workbook = simplexml_load_string($xml);
            if ($workbook === false) {
                return [];
            }

            $names = [];
            foreach ($workbook->sheets->sheet as $sheet) {
                $names[] = (string) $sheet['name'];
            }

            return $names;
        } finally {
            $zip->close();
        }
    }
}
