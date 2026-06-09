# json

JSON readers and writers for `php-data-streams`.

This package handles JSON arrays, JSON objects and NDJSON / JSON Lines inputs through a single reader entry point, plus matching streaming writers.

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

## Notes

- The reader inspects the first non-whitespace character to choose how to parse the file.
- JSON arrays are read item by item.
- JSON objects are traversed as records when using the object-oriented reader.
