# php-data-streams

[![License][ico-license]][link-license]
[![CI][ico-ci]][link-ci]

Read and write large data streams in PHP without loading everything into memory.

This repository is the monorepo home for a family of stream-oriented packages:

- `core` for shared reader and writer contracts.
- `csv` for CSV and TSV streaming.
- `json` for NDJSON / JSON Lines.
- `xml` for lazy XML node streaming.
- `kml` for KML output composed on top of XML.
- `pdo` for row-by-row database cursors.
- `http` for line and page-oriented HTTP streams.
- `excel` for minimal XLSX sheet readers.

## Why this exists

- You work with files or network bodies that are too big to materialize.
- You want small, explicit abstractions for reading and writing records.
- You prefer composition and generators over framework-specific plumbing.

## Quickstart

```php
use JLSalinas\DataStreams\Csv\CsvReader;

foreach (new CsvReader(__DIR__ . '/customers.csv') as $customer) {
    echo $customer['name'] . PHP_EOL;
}
```

## Current status

The repo has been renamed and modernized in place. The monorepo split is now present in-tree with independently publishable subpackages, and the remaining work is mainly external publication plus any future hardening you want to do per package.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ci]: https://img.shields.io/github/actions/workflow/status/jotaelesalinas/php-data-streams/ci.yml?branch=master&style=flat-square
[link-license]: https://opensource.org/licenses/MIT
[link-ci]: https://github.com/jotaelesalinas/php-data-streams/actions/workflows/ci.yml
