<?php

declare(strict_types=1);

namespace Tubee\Setup;

use Base\Mysql\Mysql;

class SetupRepository
{
    /**
     * @var \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection|null
     */
    private $connection;

    public function __construct(Mysql $mysql)
    {
        $this->connection = $mysql->getConnection();
    }

    public function createInitTable()
    {
        $this->connection->query('CREATE TABLE `youtube` (
        `id` INT NOT NULL AUTO_INCREMENT ,
        `hash` VARCHAR(64) NOT NULL UNIQUE ,
        `name` VARCHAR(255) NULL ,
        `link` VARCHAR(255) NULL UNIQUE,
        `status` TINYINT UNSIGNED NOT NULL DEFAULT 2,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
        `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY (`id`)) ENGINE = InnoDB;'
        );
    }
}