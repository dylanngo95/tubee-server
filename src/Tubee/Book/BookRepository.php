<?php

declare(strict_types=1);

namespace Tubee\Book;

use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use function React\Async\await;

/**
 * Class BookRepository
 */
class BookRepository
{
    private ConnectionInterface $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    /**
     * @throws \Throwable
     */
    public function findBook(string $year): ?Book
    {
        $result = await($this->db->query(
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