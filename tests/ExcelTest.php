<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Excel\XlsxReader;
use JLSalinas\DataStreams\Excel\XlsxSheetLister;
use PHPUnit\Framework\TestCase;
use ZipArchive;

final class ExcelTest extends TestCase
{
    public function testXlsxReaderReadsSimpleSheet(): void
    {
        $file = $this->buildMinimalXlsx();
        $rows = iterator_to_array(new XlsxReader($file, 1));

        self::assertSame([['A' => 'Ada', 'B' => '37']], $rows);
    }

    public function testSheetListerReturnsNames(): void
    {
        $file = $this->buildMinimalXlsx();

        self::assertSame(['People'], (new XlsxSheetLister())->listSheets($file));
    }

    private function buildMinimalXlsx(): string
    {
        $file = tempnam(sys_get_temp_dir(), 'xlsx');
        unlink($file);
        $zip = new ZipArchive();
        $zip->open($file, ZipArchive::CREATE);
        $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '</Types>');
        $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="People" sheetId="1" r:id="rId1"/></sheets></workbook>');
        $zip->addFromString('xl/worksheets/sheet1.xml', '<?xml version="1.0" encoding="UTF-8"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetData>'
            . '<row r="1"><c r="A1" t="inlineStr"><is><t>Ada</t></is></c><c r="B1"><v>37</v></c></row>'
            . '</sheetData></worksheet>');
        $zip->close();

        return $file;
    }
}
