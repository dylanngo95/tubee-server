<?php

declare(strict_types=1);

namespace Framework\Mysql;

use DateTime;

/**
 * Class Connection
 */
class Connection
{
    public $connection;
    public $startTime;

    public function __construct(
        Mysql $mysql
    ) {
        $this->connection = $mysql->createNewConnection();
        $this->startTime = (new DateTime)->getTimestamp();
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }
}