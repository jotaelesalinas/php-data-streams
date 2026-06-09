# pdo

Streaming PDO readers for row-by-row database iteration.

`pdo` exposes a small adapter for iterating over `PDOStatement` results as a stream of associative arrays.

## Features

- Consume database results row by row.
- Keep fetch mode fixed to associative arrays.
- Work with existing prepared statements and cursors.

## Usage

```php
use JLSalinas\DataStreams\Pdo\PdoReader;

$statement = $pdo->prepare('SELECT id, name FROM customers');
$statement->execute();

$reader = new PdoReader($statement);

foreach ($reader as $row) {
    echo $row['name'] . PHP_EOL;
}
```

## Notes

- The reader expects a `PDOStatement` that has already been executed.
- Rows are yielded as associative arrays using `PDO::FETCH_ASSOC`.
