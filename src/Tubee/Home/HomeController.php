<?php

declare(strict_types=1);

namespace Tubee\Home;

use Framework\Log\Logger;
use Framework\Log\Writer\Stream;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class HomeController
 */
class HomeController
{
    /** @var Stream $stream */
    private $stream;

    /** @var Logger $logger */
    private $logger;

    public function __construct(
        Stream $stream,
        Logger $logger
    ) {
        $this->stream = $stream;
        $this->logger = $logger;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request): Response
    {
        $writer = $this->stream->getWriter('index.log');
        $logger = $this->logger->addWriter($writer);
        $logger->write("Start Home");

        $execString = 'ps -eo comm,pcpu,pmem -u ${USER} --sort -pcpu | head -20';
        $process = "";
        exec($execString, $process);

        $listProcess = "";
        foreach ($process as $item) {
            $values = preg_replace('!\s+!', ',', $item);
            $values = explode(',', $values);

            $row = '';
            foreach ($values as $value) {
                $row .= "<td>${value}</td>";
            }
            $listProcess .= "<tr>${row}</tr>";
        }

        $style = "<style> table { border-collapse: collapse; border: 1px solid black; } th,td { border: 1px solid black; } table.a { table-layout: auto; width: 180px; } table.b { table-layout: fixed; width: 180px; } table.c { table-layout: auto; width: 100%; } table.d { table-layout: fixed; width: 100%; } </style>";
        $html = "<html>${style}<body><h1>Task running:</h1><table class='a'>${listProcess}</table></body></html>";

        return Response::html(
            $html
        );
    }
}