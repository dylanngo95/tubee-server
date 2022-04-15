<?php

declare(strict_types=1);

namespace Framework\Mysql;

/**
 * Class ConnectionPool
 */
class ConnectionPool
{
    private $minIdle;
    private $maxIdle;

    private $minConnection = 100;
    private $maxConnection = 1000;

    private $connectionActive = [];
    private $connectionIdle = [];
    private $connectionCount = 0;

    private $mysql;

    public function __construct(
        Mysql $mysql
    ){
        $this->mysql = $mysql;
        $this->initConnection();
    }

    /**
     * @return void
     */
    public function initConnection() {
        for (;$this->minConnection > 0; $this->minConnection--) {
            $connectionIdle = (new \Framework\Mysql\Connection($this->mysql))->createNewConnection();
            $key = spl_object_hash($connectionIdle);
            $this->connectionIdle[$key] = $connectionIdle;
            $this->connectionCount += 1;
        }
    }

    /**
     * @throws \Exception
     */
    public function getConnection()
    {
        if (count($this->connectionActive) >= $this->maxConnection) {
            throw new \Exception('Max connection pool ' . $this->maxConnection);
        }

        if (count($this->connectionIdle) <= 0
            && $this->connectionCount <= $this->maxConnection
        ) {
            $connectionIdle = (new \Framework\Mysql\Connection($this->mysql))->createNewConnection();
            $key = spl_object_hash($connectionIdle);
            $this->connectionIdle[$key] = $connectionIdle;
            $this->connectionCount += 1;
        }

        foreach ($this->connectionIdle as $key => $connectionIdle) {
            $this->connectionActive[$key] = $connectionIdle;
            unset($this->connectionIdle[$key]);
            return $connectionIdle;
        }

        throw new \Exception('Have not connection');
    }

    public function idleConnection($connection)
    {
        $keyClose = spl_object_hash($connection);
        foreach ($this->connectionActive as $key => $connectionActive) {
            if ($key == $keyClose) {
                $this->connectionIdle[$key] = $connectionActive;
                unset($this->connectionActive[$key]);
            }
        }
    }

    public function closeConnection($connection)
    {
        $keyClose = spl_object_hash($connection);
        foreach ($this->connectionActive as $key => $connectionActive) {
            if ($key == $keyClose) {
                $this->connectionActive[$key]->quit();
                unset($this->connectionActive[$key]);
                $this->connectionCount -= 1;
            }
        }
    }
}