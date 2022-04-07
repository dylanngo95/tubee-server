<?php

declare(strict_types=1);

namespace Tubee\Add;

use Framework\Mysql\Mysql;
use React\MySQL\Exception;
use React\MySQL\QueryResult;

class AddRepository
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
     * Insert Dump
     */
    public function insertDumpData($n = 100000) {
        for ($i = 0; $i < $n; $i++) {
            $date = date_create();
            $value = $date->getTimestamp();
            $query = "INSERT INTO `youtube` (`hash`, `name`, `link`, `status`, `created_at`, `updated_at`) VALUES ('hash ${value}', 'name ${value}', 'link ${value}', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

            $this->connection->query($query)->then(
                function (QueryResult $command) use ($query) {
                    echo 'Successfully ' . $query . PHP_EOL;
                },
                function (Exception $error) use ($query) {
                    echo 'Error ' . $query . PHP_EOL;
                }
            );;
        }
    }

}