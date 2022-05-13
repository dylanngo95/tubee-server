<?php

declare(strict_types=1);

namespace Tubee\Youtube;

use Framework\Mysql\ConnectionPool;
use React\MySQL\ConnectionInterface;
use React\MySQL\Exception;
use React\MySQL\QueryResult;

/**
 * Class YoutubeRepository
 */
class YoutubeRepository
{
    private ConnectionInterface $connection;

    /**
     * @throws \Exception
     */
    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connection = $connectionPool->getConnection();
    }

    /**
     * @param string $hash
     * @return \Generator|mixed|null
     */
    public function getYoutubeByHash(string $hash)
    {
        $result = yield $this->connection->query('SELECT * FROM youtube WHERE hash = ? LIMIT 1', [
            $hash
        ]);

        if (count($result->resultRows) === 0) {
            return null;
        }

        return $result->resultRows[0];
    }

    /**
     * @param string $hash
     * @param string $link
     * @return void
     */
    public function saveYoutube(string $hash, string $link)
    {
        $query = 'INSERT INTO `youtube` (`hash`, `link`) VALUES (?,?)';
        $this->connection->query($query, [
            $hash,
            $link
        ])->then(
            function (QueryResult $command) use ($query) {
                echo 'Successfully ' . $query . PHP_EOL;
            },
            function (Exception $error) use ($query) {
                echo 'Error ' . $query . PHP_EOL;
            }
        );
    }
}