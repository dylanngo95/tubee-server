<?php

declare(strict_types=1);

namespace Tubee\Youtube;

use Base\Mysql\Mysql;

/**
 * Class YoutubeRepository
 */
class YoutubeRepository
{
    /**
     * @var \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection|null
     */
    private $connection;

    public function __construct(Mysql $mysql)
    {
        $this->connection = $mysql->getConnection();
    }

    public function getName(string $video)
    {
        $result = yield $this->connection->query('SELECT * FROM youtube WHERE hash = ?', [
            $video
        ]);

        if (count($result->resultRows) === 0) {
            return null;
        }

        return $result->resultRows[0]['name'];
    }
}