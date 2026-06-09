# excel

Minimal XLSX readers for sheet-by-sheet streaming.

`excel` is a lightweight XLSX reader for simple extraction jobs. It focuses on reading a single worksheet into record-like arrays without introducing a full spreadsheet abstraction layer.

## Features

- Read one worksheet at a time from an `.xlsx` file.
- Resolve shared strings transparently.
- Return each row as an associative array keyed by Excel column letters.

## Usage

```php
use JLSalinas\DataStreams\Excel\XlsxReader;

$reader = new XlsxReader(__DIR__ . '/report.xlsx', 1);

foreach ($reader as $row) {
    echo $row['A'] . PHP_EOL;
}
```

## Notes

- Sheet numbers start at `1`.
- The reader targets straightforward extraction workflows, not formula calculation or formatting.
- Cell values are returned as strings.
