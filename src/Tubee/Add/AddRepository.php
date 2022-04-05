<?php

declare(strict_types=1);

namespace Tubee\Add;

use Framework\Mysql\Mysql;

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
            $query = "INSERT INTO `youtube` (`hash`, `name`, `link`, `status`, `created_at`, `updated_at`) VALUES ('hash ${i}', 'name ${i}', 'link ${i}', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
            $this->connection->query($query);
        }
    }

}