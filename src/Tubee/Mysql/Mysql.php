<?php

declare(strict_types=1);

namespace Tubee\Mysql;

use React\MySQL\Factory;

/**
 * Class Mysql
 */
class Mysql
{
    protected $db = null;
    protected $connection = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection
     */
    public function getConnection() {
        if ($this->connection) {
            return $this->connection;
        }

        $mode = 'default';
        $engine = $this->db['connection']['default']['engine'] ?? null;
        $initStatements = $this->db['connection']['default']['initStatements'] ?? null;

        $userName = $this->db['connection']['default']['username'] ?? null;
        $passWord = $this->db['connection']['default']['password'] ?? null;
        $dbName = $this->db['connection']['default']['dbname'] ?? null;
        $host = $this->db['connection']['default']['host'] ?? null;

        $credentials = "${userName}:${passWord}@${host}/${dbName}?idle=0.001";
        $this->connection = (new Factory())->createLazyConnection($credentials);
        return $this->connection;
    }
}