<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Tests;

use JLSalinas\DataStreams\Pdo\PdoReader;
use PDO;
use PHPUnit\Framework\TestCase;

final class PdoReaderTest extends TestCase
{
    public function testReadsRowsFromStatement(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->exec('CREATE TABLE users (name TEXT, age INTEGER)');
        $pdo->exec("INSERT INTO users VALUES ('Ada', 37), ('Bob', 41)");

        $statement = $pdo->query('SELECT name, age FROM users ORDER BY age');
        $rows = iterator_to_array(new PdoReader($statement));

        self::assertSame([
            ['name' => 'Ada', 'age' => 37],
            ['name' => 'Bob', 'age' => 41],
        ], $rows);
    }
}
