# core

Shared reader and writer contracts for `php-data-streams`.

`core` is the smallest package in the monorepo. It defines the interfaces used by the format-specific packages and provides a simple console writer for debugging and examples.

## What it provides

- `Reader` for lazy iteration with `IteratorAggregate`.
- `Writer` for record-by-record output with an explicit `close()` step.
- `ConsoleWriter` for printing scalars and structured data to stdout or a custom stream.

## When to use it

- You want to build your own streaming adapter for another format.
- You need to type-hint a reader or writer in application code.
- You want a tiny helper for quick CLI output during development.

## Example

```php
use JLSalinas\DataStreams\Core\ConsoleWriter;

$writer = new ConsoleWriter();
$writer->write(['status' => 'ok', 'count' => 42]);
$writer->write('done');
```

## Notes

- `ConsoleWriter` writes JSON for arrays and objects that can be encoded.
- `Writer::close()` is part of the contract so file-based implementations can flush and release resources explicitly.
