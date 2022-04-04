<?php

use Base\Config\Environment;
use Base\Mysql\Mysql;
use Tubee\Book\BookController;
use Tubee\Home\HomeController;
use Tubee\Setup\SetupController;
use Tubee\Youtube\YoutubeController;

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
$app->get('/init', SetupController::class);
$app->get('/find/{id}', BookController::class);
$app->get('/youtube/{video}', YoutubeController::class);

$app->run();
