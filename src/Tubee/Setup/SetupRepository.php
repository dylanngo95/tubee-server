<?php

declare(strict_types=1);

namespace Tubee\Setup;

use Framework\Mysql\Mysql;
use React\MySQL\ConnectionInterface;

/**
 * Class SetupRepository
 */
class SetupRepository
{
    private ConnectionInterface $connection;

    public function __construct(Mysql $mysql)
    {
        $this->connection = $mysql->createLazyConnection();
    }

    /**
     * @return string
     */
    protected function getDataTable(): string
    {
        return <<<SQL
CREATE TABLE `youtube` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `hash` VARCHAR(64) NULL,
        `name` VARCHAR(255) NULL,
        `link` VARCHAR(255) NOT NULL UNIQUE,
        `status` TINYINT UNSIGNED NOT NULL DEFAULT 0,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
        `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY (`id`)) ENGINE = InnoDB;
SQL;
    }

    public function createInitTable()
    {
        $this->connection->query($this->getDataTable());
    }
}