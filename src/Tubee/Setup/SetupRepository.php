<?php

declare(strict_types=1);

namespace Tubee\Setup;

use Framework\Mysql\Mysql;

class SetupRepository
{
    /**
     * @var \React\MySQL\ConnectionInterface|\React\MySQL\Io\LazyConnection|null
     */
    private $connection;

    public function __construct(Mysql $mysql)
    {
        $this->connection = $mysql->createNewConnection();
    }

    public function createInitTable()
    {
        $this->connection->query('CREATE TABLE `youtube` (
        `id` INT NOT NULL AUTO_INCREMENT ,
        `hash` VARCHAR(64) NOT NULL ,
        `name` VARCHAR(255) NULL ,
        `link` VARCHAR(255) NULL,
        `status` TINYINT UNSIGNED NOT NULL DEFAULT 2,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
        `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY (`id`)) ENGINE = InnoDB;'
        );
    }

    /**
     * Insert Dump
     */
    public function insertDumpData($n = 100000) {
        for ($i = 0; $i < $n; $i++) {
            $query = "INSERT INTO `youtube` (`hash`, `name`, `link`, `status`, `created_at`, `updated_at`) VALUES ('hash ${i}', 'name ${i}', 'link ${i}', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
            $this->connection->query($query);
        }
    }
}