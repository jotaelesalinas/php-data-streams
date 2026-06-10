# php-data-streams

[!IMPORTANT]
This is a breaking v2 release and is not compatible with the old
`jotaelesalinas/php-rwgen` package.
The package name, namespace, and public API have changed.

[![License][ico-license]][link-license]
[![CI][ico-ci]][link-ci]

`php-data-streams` is a PHP streaming library for reading and writing large CSV, JSON, XML, XLSX, KML, HTTP and database-backed records without loading everything into memory.

It is designed for data pipelines, import/export jobs, CLI tools and integrations where you want small, explicit reader and writer abstractions instead of heavyweight framework-specific layers.

## What it solves

- Process large files and responses record by record.
- Keep memory usage predictable while iterating through data.
- Compose simple readers and writers around generators and iterables.
- Reuse a shared contract across multiple formats.

## How This Repository Is Organized

This project is a monorepo split into several smaller packages.

That means the repository contains multiple packages in one place, but you do not need to install all of them. Install only the package or packages you actually need.

For example:

- If you only work with CSV files, install the CSV package.
- If you only need JSON Lines, install the JSON package.
- If you want the shared reader and writer interfaces for your own code, install the core package.

## Packages

- [`core`](packages/core/README.md) for the shared `Reader` and `Writer` contracts.
- [`csv`](packages/csv/README.md) for CSV and TSV readers and writers.
- [`json`](packages/json/README.md) for JSON, JSON arrays and NDJSON / JSON Lines.
- [`xml`](packages/xml/README.md) for lazy XML readers and streaming XML writers.
- [`kml`](packages/kml/README.md) for KML output built on XML.
- [`pdo`](packages/pdo/README.md) for database cursor helpers.
- [`http`](packages/http/README.md) for line and page-oriented HTTP streams.
- [`excel`](packages/excel/README.md) for minimal XLSX sheet readers.

## Quick Example

```php
use JLSalinas\DataStreams\Csv\CsvReader;

$reader = new CsvReader(__DIR__ . '/customers.csv');

foreach ($reader as $customer) {
    echo $customer['name'] . PHP_EOL;
}
```

## Installation

Install the package you need via Composer. For example, to work with CSV files:

```bash
composer require jotaelesalinas/php-data-streams-csv
```

If you want to work with JSON Lines:

```bash
composer require jotaelesalinas/php-data-streams-json
```

If you want to build your own reader or writer and only need the shared interfaces:

```bash
composer require jotaelesalinas/php-data-streams-core
```

You can also install more than one package if your project needs them.

## Example Usage

### CSV reader

```php
use JLSalinas\DataStreams\Csv\CsvReader;

$reader = new CsvReader(__DIR__ . '/customers.csv');

foreach ($reader as $customer) {
    echo $customer['name'] . PHP_EOL;
}
```

### CSV writer

```php
use JLSalinas\DataStreams\Csv\CsvWriter;

$writer = new CsvWriter(__DIR__ . '/export.csv');
$writer->write(['name' => 'Ada', 'email' => 'ada@example.com']);
$writer->write(['name' => 'Grace', 'email' => 'grace@example.com']);
$writer->close();
```

### JSON reader

```php
use JLSalinas\DataStreams\Json\JsonReader;

$reader = new JsonReader(__DIR__ . '/events.ndjson');

foreach ($reader as $event) {
    var_dump($event);
}
```

## Typical Use Cases

- CSV/TSV imports and exports.
- JSON Lines ingestion and generation.
- XML feeds and document-to-record transforms.
- XLSX sheet reading in long-running jobs.
- KML generation from geospatial records.
- Streaming database results and HTTP responses.

## Updating from v1.x

If you are coming from `jotaelesalinas/php-rwgen`, review these changes before
moving your code to this release:

- Switch Composer to the package you actually use. For example:

  ```bash
  composer remove jotaelesalinas/php-rwgen
  composer require jotaelesalinas/php-data-streams-csv
  ```

  If your project uses multiple formats, install the matching subpackages.

- Update the namespace imports. For example:

  ```php
  use JLSalinas\RWGen\CsvReader;
  ```

  becomes:

  ```php
  use JLSalinas\DataStreams\Csv\CsvReader;
  ```

- If you previously relied on the monolithic package, move each reader or
  writer to the matching subpackage. For example, CSV streaming now lives in
  `packages/csv`, while the shared contracts live in `packages/core`.

- Recheck class names and constructors when you migrate. If you used
  generic-looking classes such as `Reader` or `Writer`, they may now be
  specific implementations like `CsvReader`, `JsonReader`, `CsvWriter`, or
  `JsonLinesWriter`.

- If your code depended on a single installation for everything, verify your
  imports and `composer.json` against the [Packages](#packages) section and the
  README for each subpackage.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ci]: https://img.shields.io/github/actions/workflow/status/jotaelesalinas/php-data-streams/ci.yml?branch=master&style=flat-square
[link-license]: https://opensource.org/licenses/MIT
[link-ci]: https://github.com/jotaelesalinas/php-data-streams/actions/workflows/ci.yml
