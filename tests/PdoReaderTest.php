<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Pdo\PdoReader;

it('reads rows from a statement', function (): void {
    $pdo = new \PDO('sqlite::memory:');
    $pdo->exec('CREATE TABLE users (name TEXT, age INTEGER)');
    $pdo->exec("INSERT INTO users VALUES ('Ada', 37), ('Bob', 41)");

    $statement = $pdo->query('SELECT name, age FROM users ORDER BY age');

    expect(iterator_to_array(new PdoReader($statement)))->toBe([
        ['name' => 'Ada', 'age' => 37],
        ['name' => 'Bob', 'age' => 41],
    ]);
});
