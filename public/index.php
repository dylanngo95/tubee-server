<?php

use Base\Config\Environment;
use Base\Mysql\Mysql;
use Tubee\Book\BookController;
use Tubee\Home\HomeController;
use Tubee\Youtube\DownloadController;

require __DIR__ . '/../vendor/autoload.php';

\define('PB', \dirname(__DIR__));

$environment = new Environment();
$container = new FrameworkX\Container([
    Environment::class => fn() => new Environment(),
    Mysql::class => function() use($environment) {
        return new Mysql($environment);
    }
]);

$app = new FrameworkX\App($container);

$app->get('/', HomeController::class);
$app->get('/book/{year}', BookController::class);
$app->get('/youtube/{video}', DownloadController::class);

$app->run();
