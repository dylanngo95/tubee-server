<?php

declare(strict_types=1);

namespace Framework\Mysql;

use Framework\Config\Environment;
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
    public function getConnection()
    {
        if ($this->connection) {
            return $this->connection;
        }

        $mode = 'default';
        $engine = $this->db['connection']['default']['engine'] ?? null;
        $charset = $this->db['connection']['default']['charset'] ?? null;

        $userName = $this->db['connection'][$mode]['username'] ?? null;
        $passWord = $this->db['connection'][$mode]['password'] ?? null;
        $dbName = $this->db['connection'][$mode]['dbname'] ?? null;
        $host = $this->db['connection'][$mode]['host'] ?? null;

        $credentials = "${userName}:${passWord}@${host}/${dbName}?idle=0.001?charset=${charset}";
        $this->connection = (new Factory())->createLazyConnection($credentials);
        return $this->connection;
    }
}