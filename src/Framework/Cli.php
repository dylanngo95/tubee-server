<?php

declare(strict_types=1);

namespace Framework;

use React\EventLoop\Loop;
use Symfony\Component\Console\Application;
use Tubee\Youtube\YoutubeDownloadCommand;

/**
 * Class Cli
 */
class Cli
{
    private Application $app;

    public function __construct()
    {
        $this->app = new Application();
    }

    /**
     * @throws \Exception
     */
    public function run() {
        $this->app->add(new YoutubeDownloadCommand());
        $this->app->run();
        Loop::run();
    }
}