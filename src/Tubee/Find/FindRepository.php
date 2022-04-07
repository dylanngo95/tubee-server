<?php

declare(strict_types=1);

namespace Tubee\Find;

use Framework\Mysql\Mysql;

/**
 * Class FindRepository
 */
class FindRepository
{
    /**
     * @var \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection|null
     */
    private $connection;

    /**
     * @var Mysql
     */
    private $mysql;

    public function __construct(Mysql $mysql)
    {
        $this->mysql = $mysql;
        $this->connection = $mysql->getConnection();
    }

    /**
     * @throws \Throwable
     */
    public function findById(string $id)
    {
        $connection = $this->mysql->getConnection();
        $result =  yield $connection->query(
            'SELECT * FROM youtube WHERE id = ?',
            [$id]
        );

        if (count($result->resultRows) === 0) {
            return null;
        }

        return new Youtube($result->resultRows[0]);
    }
}