# http

Lazy HTTP-oriented readers for line and page streaming.

`http` provides tiny adapters for turning HTTP-derived iterables into flat record streams.

## Which Class Should I Use?

- `HttpLinesReader` when you have a list of response lines and want to skip blanks.
- `HttpPagesReader` when your API returns pages of results and you want one continuous stream.

## Features

- Normalize iterables of lines by trimming whitespace and skipping empties.
- Flatten paginated result sets into a single record stream.
- Keep the adapter layer separate from the transport/client code.

## Usage

```php
use JLSalinas\DataStreams\Http\HttpLinesReader;
use JLSalinas\DataStreams\Http\HttpPagesReader;

$lines = new HttpLinesReader($responseLines);
foreach ($lines as $line) {
    echo $line . PHP_EOL;
}

$pages = new HttpPagesReader($paginatedResults);
foreach ($pages as $record) {
    var_dump($record);
}
```

## Notes

- `HttpLinesReader` trims every line before yielding it.
- Empty lines are skipped.
- `HttpPagesReader` simply flattens the nested iterables; it does not transform the payload.
