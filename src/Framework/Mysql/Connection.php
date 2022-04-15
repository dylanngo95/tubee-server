<?php

declare(strict_types=1);

namespace Framework\Mysql;

/**
 * Class Connection
 */
class Connection
{
    public $connection;
    public $startTime;

    private $mysql;

    public function __construct(
        Mysql $mysql
    ) {
        $this->mysql = $mysql;
        $this->connection = $this->mysql->createNewConnection();
        $this->startTime = new \DateTime();
    }

    public function createNewConnection() {
        return $this->connection;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }
}