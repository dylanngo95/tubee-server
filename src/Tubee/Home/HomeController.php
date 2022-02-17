<?php

declare(strict_types=1);

namespace Tubee\Home;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class HomeController
 */
class HomeController
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        return Response::plaintext(
            "Hello my friend!\n"
        );
    }
}