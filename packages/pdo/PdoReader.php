<?php

declare(strict_types=1);

namespace JLSalinas\DataStreams\Pdo;

use JLSalinas\DataStreams\Core\Reader;
use PDOStatement;

final class PdoReader implements Reader
{
    public function __construct(private readonly PDOStatement $statement)
    {
    }

    public function getIterator(): \Traversable
    {
        $this->statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $this->statement->fetch()) !== false) {
            yield $row;
        }
    }
}
