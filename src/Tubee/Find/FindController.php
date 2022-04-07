<?php

declare(strict_types=1);

namespace Tubee\Find;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class FindController
 */
class FindController
{
    /**
     * @var FindRepository $repository
     */
    private $repository;

    public function __construct(FindRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $year = $request->getAttribute('id');
        $youtube = yield from $this->repository->findById($year);

        if ($youtube === null) {
            return Response::json(
                [
                    'data' => "Youtube not found\n"
                ]
            )->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $data = $youtube->title;
        return Response::json(
            [
                'data' => $data
            ]
        );
    }
}