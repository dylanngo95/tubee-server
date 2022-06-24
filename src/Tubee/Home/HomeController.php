<?php

declare(strict_types=1);

namespace Tubee\Home;

use Framework\Config\Environment;
use Framework\Log\Logger;
use Framework\Log\Writer\Stream;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class HomeController
 */
class HomeController
{
    private Stream $stream;
    private Logger $logger;
    private Environment $environment;

    private $writer;

    /**
     * @param Stream $stream
     * @param Logger $logger
     * @param Environment $environment
     */
    public function __construct(
        Stream $stream,
        Logger $logger,
        Environment $environment
    ) {
        $this->stream = $stream;
        $this->logger = $logger;
        $this->environment = $environment;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request): Response
    {
//        $logFolder = $this->environment->getLogPath();
//        if (!$this->writer) {
//            $this->writer = $this->stream->createWriter($logFolder . '/home.log');
//            $this->logger = $this->logger->addWriter($this->writer);
//        }
//        $this->logger->write("Start Home");
//
//        $execString = 'ps -eo comm,pcpu,pmem -u ${USER} --sort -pcpu | head -20';
//        $process = "";
//        exec($execString, $process);
//
//        $listProcess = "";
//        foreach ($process as $item) {
//            $values = preg_replace('!\s+!', ',', $item);
//            $values = explode(',', $values);
//
//            $row = '';
//            foreach ($values as $value) {
//                $row .= "<td>${value}</td>";
//            }
//            $listProcess .= "<tr>${row}</tr>";
//        }
//
//        $style = "<style> table { border-collapse: collapse; border: 1px solid black; } th,td { border: 1px solid black; } table.a { table-layout: auto; width: 180px; } table.b { table-layout: fixed; width: 180px; } table.c { table-layout: auto; width: 100%; } table.d { table-layout: fixed; width: 100%; } </style>";
        $html = "<html><body><h1>Task running:</h1><table class='a'></table></body></html>";

        return Response::html(
            $html
        );
    }
}