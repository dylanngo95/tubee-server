<?php

declare(strict_types=1);

namespace Framework\Mysql;

/**
 * Class ConnectionPool
 */
class ConnectionPool
{
    private $idleTimeOut = 1000;

    private $minConnection = 200;
    private $maxConnection = 500;

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
            $connectionIdle = (new \Framework\Mysql\Connection($this->mysql));
            $key = spl_object_hash($connectionIdle->getConnection());
            $this->connectionIdle[$key] = $connectionIdle;
            $this->connectionCount++;
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
            $connectionIdle = (new \Framework\Mysql\Connection($this->mysql));
            $key = spl_object_hash($connectionIdle->getConnection());
            $this->connectionIdle[$key] = $connectionIdle;
            $this->connectionCount++;
        }

        foreach ($this->connectionIdle as $key => $connectionIdle) {
            $this->connectionActive[$key] = $connectionIdle;
            unset($this->connectionIdle[$key]);
            return $connectionIdle->getConnection();
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
                $this->connectionCount--;
            }
        }
    }

    public function freeIdleConnection()
    {
        $connectionIdleCount = count($this->connectionIdle) ?? 0;
        if ($connectionIdleCount <= $this->minConnection) return;

        foreach ($this->connectionIdle as $key => $connectionIdle) {
            $connectionIdleCount = count($this->connectionIdle) ?? 0;
            if ($connectionIdleCount <= $this->minConnection) return;

            $startTime = $connectionIdle->getStartTime();
            $now = (new \DateTime())->getTimestamp();
            if ($now - $startTime <= $this->idleTimeOut) {
                continue;
            }
            $this->connectionIdle[$key]->quit();
            unset($this->connectionIdle[$key]);
            $this->connectionCount--;
        }
    }
}