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
    /** @var Environment $environment */
    private $environment;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection
     */
    public function createNewConnection()
    {
        $dbConfig = $this->environment->getDBConfig();
        $mode = 'default';
        $engine = $dbConfig['connection']['default']['engine'] ?? null;
        $charset = $dbConfig['connection']['default']['charset'] ?? null;

        $userName = $dbConfig['connection'][$mode]['username'] ?? null;
        $passWord = $dbConfig['connection'][$mode]['password'] ?? null;
        $dbName = $dbConfig['connection'][$mode]['dbname'] ?? null;
        $host = $dbConfig['connection'][$mode]['host'] ?? null;

        $credentials = "${userName}:${passWord}@${host}/${dbName}?idle=0.001?charset=${charset}";
        return (new Factory())->createLazyConnection($credentials);
    }
}