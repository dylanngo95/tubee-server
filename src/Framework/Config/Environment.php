<?php

declare(strict_types=1);

namespace Framework\Config;

/**
 * Class Environment
 */
class Environment
{
    /** @var mixed $dbConfig */
    private $dbConfig;

    public function getEnvironment()
    {
        return include_once PB . '/public/app/env.php';
    }

    public function getDBConfig() {
        if ($this->dbConfig) {
            return $this->dbConfig;
        }
        $environments = $this->getEnvironment();
        $this->dbConfig = $environments['db'];
        return $this->dbConfig;
    }

    public function getStaticPath() {
        return PB . '/public/static';
    }
}