# php-data-streams

[![License][ico-license]][link-license]
[![CI][ico-ci]][link-ci]

`php-data-streams` is a PHP streaming library for reading and writing large CSV, JSON, XML, XLSX, KML, HTTP and database-backed records without loading everything into memory.

It is designed for data pipelines, import/export jobs, CLI tools and integrations where you want small, explicit reader and writer abstractions instead of heavyweight framework-specific layers.

## What it solves

- Process large files and responses record by record.
- Keep memory usage predictable while iterating through data.
- Compose simple readers and writers around generators and iterables.
- Reuse a shared contract across multiple formats.

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

Install the package you need via Composer. For example, to work with CSV streams:

```bash
composer require jotaelesalinas/php-data-streams-csv
```

If you want to use the shared contracts directly:

```bash
composer require jotaelesalinas/php-data-streams-core
```

## Typical Use Cases

- CSV/TSV imports and exports.
- JSON Lines ingestion and generation.
- XML feeds and document-to-record transforms.
- XLSX sheet reading in long-running jobs.
- KML generation from geospatial records.
- Streaming database results and HTTP responses.

## Project Status

This repository is the monorepo home for independently publishable packages. The codebase has been renamed and reorganized around the `JLSalinas\DataStreams` namespace, and the README files in each package document the current runtime behavior.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ci]: https://img.shields.io/github/actions/workflow/status/jotaelesalinas/php-data-streams/ci.yml?branch=master&style=flat-square
[link-license]: https://opensource.org/licenses/MIT
[link-ci]: https://github.com/jotaelesalinas/php-data-streams/actions/workflows/ci.yml
