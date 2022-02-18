<?php

declare(strict_types=1);

namespace Base\Mysql;

use Base\Config\Environment;
use React\MySQL\Factory;

/**
 * Class Mysql
 */
class Mysql
{
    /**
     * @var array
     */
    protected $db = null;

    /**
     * @var \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection
     */
    protected $connection = null;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->db = $environment->getDBConfig();
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