# csv

Streaming CSV and TSV adapters for `php-data-streams`.

`csv` gives you a simple file-based reader and writer for delimited records. It is a good fit for imports, exports and interchange files where you want predictable memory usage and plain PHP arrays.

## Features

- Read CSV files row by row.
- Automatically map the first row to associative array keys by default.
- Write records back to CSV with optional headers.
- Work with TSV via `fromTsv()`.

## Usage

```php
use JLSalinas\DataStreams\Csv\CsvReader;
use JLSalinas\DataStreams\Csv\CsvWriter;

$reader = new CsvReader(__DIR__ . '/customers.csv');

foreach ($reader as $customer) {
    echo $customer['name'] . PHP_EOL;
}

$writer = new CsvWriter(__DIR__ . '/export.csv');
$writer->write(['name' => 'Ada', 'email' => 'ada@example.com']);
$writer->write(['name' => 'Grace', 'email' => 'grace@example.com']);
$writer->close();
```

## TSV

Use the TSV helpers when your source uses tabs instead of commas:

```php
use JLSalinas\DataStreams\Csv\CsvReader;
use JLSalinas\DataStreams\Csv\CsvWriter;

$reader = CsvReader::fromTsv(__DIR__ . '/customers.tsv');
$writer = CsvWriter::fromTsv(__DIR__ . '/export.tsv');
```

## Notes

- The writer expects associative arrays.
- Once the CSV header has been written, new keys are rejected to keep columns stable.
- Empty rows are skipped on read.
