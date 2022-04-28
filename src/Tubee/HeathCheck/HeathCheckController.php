<?php

declare(strict_types=1);

namespace Tubee\HeathCheck;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class HeathCheckController
 */
class HeathCheckController
{
    public function __invoke(ServerRequestInterface $request)
    {
        return Response::json(
            [
                'data' => 'I am fine'
            ]
        )->withStatus(StatusCodeInterface::STATUS_OK);
    }
}