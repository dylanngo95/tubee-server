<?php

use Tubee\Add\AddController;
use Tubee\Find\FindController;
use Tubee\HealthCheck\HealthCheckController;
use Tubee\Home\HomeController;
use Tubee\Setup\SetupController;
use Tubee\Youtube\YoutubeController;

try {
    require __DIR__ . '/../src/app/bootstrap.php';
} catch (\Exception $e) {
    echo 'Load bootstrap error: ' . $e->getMessage();
    exit(1);
}

$container = new FrameworkX\Container([
]);

$app = new FrameworkX\App($container);

$app->get('/', HomeController::class);
$app->get('/init', SetupController::class);
$app->get('/new/{number}', AddController::class);
$app->get('/find/{id}', FindController::class);
$app->get('/health-check', HealthCheckController::class);
$app->get('/download/{v}', YoutubeController::class);

$app->run();
