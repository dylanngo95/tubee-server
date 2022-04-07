<?php

use Framework\Config\Environment;
use Framework\Mysql\Mysql;
use Tubee\Add\AddController;
use Tubee\Find\FindController;
use Tubee\Home\HomeController;
use Tubee\Setup\SetupController;
use Tubee\Youtube\YoutubeController;

require __DIR__ . '/../vendor/autoload.php';

\define('PB', \dirname(__DIR__));

$environment = new Environment();
$container = new FrameworkX\Container([
    Environment::class => fn() => new Environment(),
    Mysql::class => function () use ($environment) {
        return new Mysql($environment);
    }
]);

$app = new FrameworkX\App($container);

$app->get('/', HomeController::class);
$app->get('/init', SetupController::class);
$app->get('/new/{number}', AddController::class);
$app->get('/find/{id}', FindController::class);
$app->get('/youtube/{video}', YoutubeController::class);

$app->run();
