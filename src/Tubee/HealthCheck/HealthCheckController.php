<?php

declare(strict_types=1);

namespace Tubee\HealthCheck;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class HealthCheckController
 */
class HealthCheckController
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