<?php

declare(strict_types=1);

namespace Tubee\Book;

use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use Tubee\Mysql\Mysql;
use function React\Async\await;

/**
 * Class BookRepository
 */
class BookRepository
{
    /**
     * @var ConnectionInterface|\React\MySQL\Io\LazyConnection|null $db
     */
    private $db;

    public function __construct(Mysql $mysql)
    {
        $this->db = $mysql->getConnection();
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