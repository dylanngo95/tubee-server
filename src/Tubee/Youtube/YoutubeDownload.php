<?php

declare(strict_types=1);

namespace Tubee\Youtube;

use Framework\Config\Environment;
use Framework\Mysql\Mysql;
use React\EventLoop\Loop;
use React\MySQL\ConnectionInterface;

/**
 * Class YoutubeDownload
 */
class YoutubeDownload
{
    private ConnectionInterface $connection;
    private Mysql $mysql;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $environment = new Environment();
        $this->mysql = new Mysql($environment);
        $this->connection = $this->mysql->createConnection(Loop::get());
    }

    /**
     * @return \Generator|void
     * @throws \Exception
     */
    public function download()
    {
        $youtube = yield $this->getYoutubeShouldDownload($this->connection);
        if (!$youtube) {
            return;
        }
        $link = $youtube['link'];
        $tmp = 0;
    }

    /**
     * @param $connection
     * @return \Generator|mixed|null
     */
    protected function getYoutubeShouldDownload($connection)
    {
        $result = yield $connection->query('SELECT * FROM youtube WHERE status = 0 LIMIT 1');
        if (count($result->resultRows) === 0) {
            return null;
        }
        return $result->resultRows[0];
    }
}