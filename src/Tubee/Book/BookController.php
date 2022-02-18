<?php

declare(strict_types=1);

namespace Tubee\Book;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class BookController
 */
class BookController
{
    /**
     * @var BookRepository $repository
     */
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $year = $request->getAttribute('year');
        $book = yield from $this->repository->findBook($year);

        if ($book === null) {
            return Response::json(
                [
                    'data' => "Book not found\n"
                ]
            )->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $data = $book->title;
        return Response::json(
            [
                'data' => $data
            ]
        );
    }
}