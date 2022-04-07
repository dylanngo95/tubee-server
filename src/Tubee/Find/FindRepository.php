<?php

declare(strict_types=1);

namespace Tubee\Find;

use Framework\Mysql\ConnectionPool;

/**
 * Class FindRepository
 */
class FindRepository
{
    /** @var ConnectionPool $connectionPool */
    private $connectionPool;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connectionPool = $connectionPool;
    }

    /**
     * @throws \Throwable
     */
    public function findById(string $id)
    {
        $connection = $this->connectionPool->getConnection();
        $result =  yield $connection->query(
            'SELECT * FROM youtube WHERE id = ?',
            [$id]
        );

        if (count($result->resultRows) === 0) {
            return null;
        }

        $youTubes = [];
        foreach ($result->resultRows as $resultRow) {
            $youTubes[] = new YouTube($resultRow);
        }

        return $youTubes;
    }
}