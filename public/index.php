<?php

use React\MySQL\Factory;
use Tubee\Book\BookController;
use Tubee\Book\BookRepository;
use Tubee\Home\HomeController;
use Tubee\Youtube\DownloadController;

require __DIR__ . '/../vendor/autoload.php';

$credentials = 'tubee:123456@localhost/bookstore?idle=0.001';
$connection = (new Factory())->createLazyConnection($credentials);

$container = new FrameworkX\Container([
    BookRepository::class => function() use($connection) {
        return new BookRepository($connection);
    }
]);

$app = new FrameworkX\App($container);

$app->get('/', HomeController::class);
$app->get('/book/{year}', BookController::class);
$app->get('/youtube/{video}', DownloadController::class);

$app->run();
