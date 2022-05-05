<?php

declare(strict_types=1);

namespace Tubee\Youtube;

use Framework\Mysql\ConnectionPool;

/**
 * Class YoutubeRepository
 */
class YoutubeRepository
{
    /** @var \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection  */
    private $connection;

    /**
     * @throws \Exception
     */
    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connection = $connectionPool->getConnection();
    }

    public function getNameByHash(string $hash)
    {
        $result = yield $this->connection->query('SELECT * FROM youtube WHERE hash = ?', [
            $hash
        ]);

        if (count($result->resultRows) === 0) {
            return null;
        }

        return $result->resultRows[0]['name'];
    }
}