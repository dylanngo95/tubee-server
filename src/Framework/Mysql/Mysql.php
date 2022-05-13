<?php

declare(strict_types=1);

namespace Framework\Mysql;

use DateTime;
use Framework\Config\Environment;
use React\EventLoop\LoopInterface;
use React\MySQL\ConnectionInterface;
use React\MySQL\Factory;
use function Clue\React\Block\await;

/**
 * Class Mysql
 */
class Mysql
{
    private Environment $environment;
    private ConnectionInterface $connection;
    private int $startTime;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    protected function getConnectionString() {

        $dbConfig = $this->environment->getDBConfig();
        $mode = 'default';
        $engine = $dbConfig['connection']['default']['engine'] ?? null;
        $charset = $dbConfig['connection']['default']['charset'] ?? null;

        $userName = $dbConfig['connection'][$mode]['username'] ?? null;
        $passWord = $dbConfig['connection'][$mode]['password'] ?? null;
        $dbName = $dbConfig['connection'][$mode]['dbname'] ?? null;
        $host = $dbConfig['connection'][$mode]['host'] ?? null;

        return "$userName:$passWord@$host/$dbName?idle=0.001?charset=$charset";
    }

    /**
     * @return ConnectionInterface
     */
    public function createLazyConnection()
    {
        $this->startTime = (new DateTime())->getTimestamp();
        $this->connection = (new Factory())->createLazyConnection($this->getConnectionString());
        return $this->connection;
    }

    /**
     * @param LoopInterface $loop
     * @return ConnectionInterface
     * @throws \Exception
     */
    public function createConnection(LoopInterface $loop)
    {
        $factory = new Factory($loop);
        $promise = $factory->createConnection($this->getConnectionString());
        return await($promise, $loop, 10.0);
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

}