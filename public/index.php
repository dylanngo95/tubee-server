<?php

use Tubee\Book\BookController;
use Tubee\Home\HomeController;
use Tubee\Mysql\Mysql;
use Tubee\Youtube\DownloadController;

require __DIR__ . '/../vendor/autoload.php';

$environments = include_once 'env.php';
$dbConfig = $environments['db'];

$container = new FrameworkX\Container([
    Mysql::class => function() use($dbConfig) {
        return new Mysql($dbConfig);
    }
]);

$app = new FrameworkX\App($container);

$app->get('/', HomeController::class);
$app->get('/book/{year}', BookController::class);
$app->get('/youtube/{video}', DownloadController::class);

$app->run();
