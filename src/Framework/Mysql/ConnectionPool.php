<?php

declare(strict_types=1);

namespace Framework\Mysql;

use Framework\Config\Environment;

/**
 * Class ConnectionPool
 */
class ConnectionPool
{
    private $minIdle;
    private $maxIdle;
    private $maxTotal;

    private $connectionWorking = [];
    private $connectionIdle = [];

    private $environment;

    private $mysql;

    public function __construct(Mysql $mysql)
    {
        $this->mysql = $mysql;
    }

    public function getConnection()
    {
        if (!count($this->connectionIdle)) {
            $this->connectionIdle[] = $this->mysql->createNewConnection();
        }
        $connectionIdle = array_pop($this->connectionIdle);
        $key = spl_object_hash($connectionIdle);
        $this->connectionWorking[$key] = $connectionIdle;
        return $connectionIdle;
    }
}