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
        $execString = 'ps -f -u dylan 2>&1 | grep youtube-dl';
        $process = "";
        exec($execString, $process);

        $listProcess = "";
        foreach ($process as $item) {
            $listProcess .= "<li>${item}</li>";
        }
        $html = "<html><body><h1>Task running:</h1><ul>${listProcess}</ul></body></html>";

        return Response::html(
            $html
        );
    }
}