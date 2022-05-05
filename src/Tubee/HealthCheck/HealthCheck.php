<?php

declare(strict_types=1);

namespace Tubee\HealthCheck;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class HealthCheck
 */
class HealthCheck
{
    public function __invoke(ServerRequestInterface $request)
    {
        return Response::json(
            [
                'status' => 'fine'
            ]
        );
    }
}