<?php

declare(strict_types=1);

namespace Tubee\Book;

use Base\Mysql\Mysql;
use React\MySQL\QueryResult;
use function React\Async\await;

/**
 * Class BookRepository
 */
class BookRepository
{
    /**
     * @var \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection|null
     */
    private $connection;

    public function __construct(Mysql $mysql)
    {
        $this->connection = $mysql->getConnection();
    }

    /**
     * @throws \Throwable
     */
    public function findBook(string $year): ?Book
    {
        $result = await($this->connection->query(
            'SELECT title FROM book WHERE year = ?',
            [$year]
        ));
        assert($result instanceof QueryResult);

        if (count($result->resultRows) === 0) {
            return null;
        }

        return new Book($result->resultRows[0]['title']);
    }
}