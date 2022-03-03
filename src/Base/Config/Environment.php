<?php

declare(strict_types=1);

namespace Base\Config;

/**
 * Class Environment
 */
class Environment
{
    public function getEnvironment()
    {
        return include_once PB . '/public/app/env.php';
    }

    public function getDBConfig() {
        $environments = $this->getEnvironment();
        return $environments['db'];
    }

    public function getStaticPath() {
        return PB . '/public/static';
    }
}