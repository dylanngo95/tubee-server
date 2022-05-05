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

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return include_once PB . '/src/app/env.php';
    }

    /**
     * @return mixed
     */
    public function getDBConfig() {
        if ($this->dbConfig) {
            return $this->dbConfig;
        }
        $environments = $this->getEnvironment();
        $this->dbConfig = $environments['db'];
        return $this->dbConfig;
    }

    /**
     * @return string
     */
    public function getStaticPath() {
        return PB . '/public/static';
    }

    /**
     * @return string
     */
    public function getLogPath() {
        return PB . '/var/log';
    }
}