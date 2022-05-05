<?php

declare(strict_types=1);

namespace Tubee\Add;

use Fig\Http\Message\StatusCodeInterface;
use Framework\Config\Environment;
use Framework\Log\Logger;
use Framework\Log\Writer\Stream;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class AddController
 */
class AddController
{
    private AddRepository $addRepository;
    private Logger $logger;
    private Stream $stream;
    private Environment $environment;

    public function __construct(
        AddRepository $addRepository,
        Stream $stream,
        Logger $logger,
        Environment $environment
    ) {
        $this->addRepository = $addRepository;
        $this->stream = $stream;
        $this->logger = $logger;
        $this->environment = $environment;
    }

    /**
     * @param ServerRequestInterface $request
     * @return \RingCentral\Psr7\Response
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $logFolder = $this->environment->getLogPath();
        $writer = $this->stream->getWriter($logFolder . '/add.log');
        $logger = $this->logger->addWriter($writer);

        $number = $request->getAttribute('number');
        $logger->write("Start Add ${number}");

        $this->addRepository->insertDumpData($number);

        $logger->write("End Add ${number}");

        return Response::json(
            [
                'data' => 'Insert completed',
                'message' => '',
                'code' => ''
            ]
        )->withStatus(StatusCodeInterface::STATUS_OK);
    }
}