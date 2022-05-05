<?php

declare(strict_types=1);

namespace Framework\Mysql;

use React\EventLoop\Loop;

/**
 * Class ConnectionPool
 */
class ConnectionPool
{
    private $idleTimeOut = 10;
    private $connectionTimeOut = 100;

    private $minConnection = 100;
    private $maxConnection = 200;

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
        $initConnection = $this->minConnection;
        for (;$initConnection > 0; $initConnection--) {
            $connectionIdle = (new \Framework\Mysql\Connection($this->mysql));
            $key = spl_object_hash($connectionIdle->getConnection());
            $this->connectionIdle[$key] = $connectionIdle;
            $this->connectionCount++;
        }

        // Remove connection Idle
        Loop::addPeriodicTimer(5, function () {
            $memory = memory_get_usage() / 1024;
            $formatted = number_format($memory, 3).'K';
            echo "====================\n";
            echo "Current memory usage: {$formatted}\n";
            $this->freeIdleConnection();
        });
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
                $this->connectionActive[$key]->getConnection()->quit();
                unset($this->connectionActive[$key]);
                $this->connectionCount--;
            }
        }
    }

    public function freeIdleConnection()
    {
        echo 'Current connection Active - ' . count($this->connectionActive) . PHP_EOL;
        echo 'Current connection Idle - ' . count($this->connectionIdle) . PHP_EOL;
        echo 'Current connection Count - ' . $this->connectionCount . PHP_EOL;
        echo 'Current min connection Count - ' . $this->minConnection . PHP_EOL;

        echo '====================== Idle' . PHP_EOL;
        // Remove Idle connection time out
        foreach ($this->connectionIdle as $key => $connectionIdle) {
            $connectionIdleCount = count($this->connectionIdle) ?? 0;
            if ($connectionIdleCount <= $this->minConnection) break;

            $startTime = $connectionIdle->getStartTime();
            $now = (new \DateTime())->getTimestamp();
            if (($diff = $now - $startTime) <= $this->idleTimeOut) {
                continue;
            }
            echo 'idleTimeOut - ' . $this->idleTimeOut . PHP_EOL;
            echo 'Diff time - ' . $diff . PHP_EOL;
            echo 'Quit connection Idle - ' . $key . PHP_EOL;
            $this->connectionIdle[$key]->getConnection()->quit();
            unset($this->connectionIdle[$key]);
            $this->connectionCount--;
            break;
        }

        echo '====================== Active' . PHP_EOL;
        // Remove active connection timeout
        foreach ($this->connectionActive as $key => $connectionActive) {
            echo '====================== Active 1' . PHP_EOL;
            $startTime = $connectionActive->getStartTime();
            echo 'Active Start Time - ' . $startTime . PHP_EOL;
            $now = (new \DateTime())->getTimestamp();
            if (($diff = $now - $startTime) <= $this->connectionTimeOut) {
                continue;
            }
            echo 'Active TimeOut - ' . $this->connectionTimeOut . PHP_EOL;
            echo 'Diff time - ' . $diff . PHP_EOL;
            echo 'Quit connection Active - ' . $key . PHP_EOL;
            $this->connectionActive[$key]->getConnection()->quit();
            unset($this->connectionActive[$key]);
            $this->connectionCount--;
            break;
        }
    }
}