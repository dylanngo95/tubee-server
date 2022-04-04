<?php

declare(strict_types=1);

namespace Tubee\Book;

use Base\Mysql\Mysql;
use React\MySQL\QueryResult;

/**
 * Class BookRepository
 */
class BookRepository
{
    /**
     * @var \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection|null
     */
    private $connection;

    private $mysql;

    public function __construct(Mysql $mysql)
    {
        $this->mysql = $mysql;
        $this->connection = $mysql->getConnection();
    }

    /**
     * @throws \Throwable
     */
    public function findBook(string $year)
    {
        $connection = $this->mysql->getConnection();
        $result =  yield $connection->query(
            'SELECT name FROM youtube WHERE id = ?',
            [$year]
        );
        assert($result instanceof QueryResult);

        if (count($result->resultRows) === 0) {
            return null;
        }

        return new Book($result->resultRows[0]['name']);
    }
}