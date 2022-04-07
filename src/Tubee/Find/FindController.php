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
        $id = $request->getAttribute('id');
        $youTubes = yield from $this->repository->findById($id);

        if (!$youTubes) {
            return Response::json(
                [
                    'data' => "Youtube not found"
                ]
            )->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }
        $data = json_encode($youTubes);

        return Response::json(
            [
                'data' => $data
            ]
        );
    }
}