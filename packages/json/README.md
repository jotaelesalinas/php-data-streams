# json

JSON readers and writers for `php-data-streams`.

This package handles JSON arrays, JSON objects and NDJSON / JSON Lines inputs through a single reader entry point, plus matching streaming writers.

## Which Class Should I Use?

- `JsonReader` if you do not want to think about the input shape first. It looks at the file and chooses the right reader.
- `JsonArrayReader` if the file contains a top-level JSON array like `[{...}, {...}]`.
- `JsonObjectReader` if the file contains a top-level JSON object and you want to read its records as key/value pairs.
- `JsonLinesReader` if the file contains one JSON value per line, also called NDJSON or JSON Lines.
- `JsonArrayWriter` if you want to build a JSON array record by record.
- `JsonObjectWriter` if you want to build a JSON object from `[key, value]` pairs.
- `JsonLinesWriter` if you want one JSON value per line.

## Features

- Detects the input shape and selects the right reader automatically.
- Supports JSON arrays, JSON objects and line-delimited JSON.
- Works well for event streams, exports and append-friendly log formats.

## Usage

```php
use JLSalinas\DataStreams\Json\JsonReader;

$reader = new JsonReader(__DIR__ . '/events.ndjson');

foreach ($reader as $event) {
    var_dump($event);
}
```

## Reader Examples

### JSON array

```php
use JLSalinas\DataStreams\Json\JsonArrayReader;

$reader = new JsonArrayReader(__DIR__ . '/events.json');
```

### JSON object

```php
use JLSalinas\DataStreams\Json\JsonObjectReader;

$reader = new JsonObjectReader(__DIR__ . '/settings.json');
```

### JSON Lines

```php
use JLSalinas\DataStreams\Json\JsonLinesReader;

$reader = new JsonLinesReader(__DIR__ . '/events.ndjson');
```

## Writer Examples

### JSON array writer

```php
use JLSalinas\DataStreams\Json\JsonArrayWriter;

$writer = new JsonArrayWriter(__DIR__ . '/events.json');
$writer->write(['id' => 1, 'name' => 'Ada']);
$writer->write(['id' => 2, 'name' => 'Grace']);
$writer->close();
```

### JSON object writer

```php
use JLSalinas\DataStreams\Json\JsonObjectWriter;

$writer = new JsonObjectWriter(__DIR__ . '/settings.json');
$writer->write(['name', 'Demo']);
$writer->write(['enabled', true]);
$writer->close();
```

### JSON Lines writer

```php
use JLSalinas\DataStreams\Json\JsonLinesWriter;

$writer = new JsonLinesWriter(__DIR__ . '/events.ndjson');
$writer->write(['id' => 1, 'name' => 'Ada']);
$writer->close();
```

## Notes

- The reader inspects the first non-whitespace character to choose how to parse the file.
- JSON arrays are read item by item.
- `JsonObjectWriter` expects a two-item list in the form `[key, value]`.
