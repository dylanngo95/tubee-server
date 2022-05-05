<?php

declare(strict_types=1);

namespace Tubee\Add;

use Framework\Mysql\ConnectionPool;
use React\MySQL\Exception;
use React\MySQL\QueryResult;

/**
 * Class AddRepository
 */
class AddRepository
{
    /** @var ConnectionPool $connectionPool */
    private $connectionPool;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connectionPool = $connectionPool;
    }

    /**
     * Insert Dump
     */
    public function insertDumpData($n = 100) {
        $connection = $this->connectionPool->getConnection();

        $query = "INSERT INTO `youtube` (`hash`, `name`, `link`, `status`, `created_at`, `updated_at`) VALUES";
        for ($i = 0; $i < $n; $i++) {
            $date = date_create();
            $value = $date->getTimestamp();
            $queryValue[] = "('hash ${value}', 'name ${value}', 'link ${value}', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        }
        $queryValue = join(",", $queryValue);
        $query = "${query} $queryValue;";
        $connection->query($query)->then(
            function (QueryResult $command) use ($query) {
//                echo 'Successfully ' . $query . PHP_EOL;
            },
            function (Exception $error) use ($query) {
                echo 'Error ' . $query . PHP_EOL;
            }
        );
        $this->connectionPool->idleConnection($connection);
    }

}