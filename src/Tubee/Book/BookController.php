<?php

declare(strict_types=1);

namespace Tubee\Book;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class BookController
 */
class BookController
{
    private BookRepository $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $book = $this->repository->findBook($year);

        if ($book === null) {
            return Response::json(
                [
                    'data' => "Book not found\n"
                ]
            )->withStatus(Response::STATUS_NOT_FOUND);
        }

        $data = $book->title;
        return Response::json(
            [
                'data' => $data
            ]
        );
    }
}