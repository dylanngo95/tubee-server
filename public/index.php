<?php

use Tubee\Add\AddController;
use Tubee\Find\FindController;
use Tubee\HealthCheck\HealthCheckController;
use Tubee\Home\HomeController;
use Tubee\Setup\SetupController;
use Tubee\Youtube\YoutubeController;

require __DIR__ . '/../vendor/autoload.php';

\define('PB', \dirname(__DIR__));

$container = new FrameworkX\Container([
]);

$app = new FrameworkX\App($container);

$app->get('/', HomeController::class);
$app->get('/init', SetupController::class);
$app->get('/new/{number}', AddController::class);
$app->get('/find/{id}', FindController::class);
$app->get('/health-check', HealthCheckController::class);
$app->get('/youtube/{video}', YoutubeController::class);

$app->run();
