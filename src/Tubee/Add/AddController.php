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

    private $writer;

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
        if (!$this->writer) {
            $this->writer = $this->stream->createWriter($logFolder . '/add.log');
            $this->logger = $this->logger->addWriter($this->writer);
        }

        $number = $request->getAttribute('number');

        $this->logger->write("Start Add ${number}");
        $this->addRepository->insertDumpData($number);
        $this->logger->write("End Add ${number}");

        return Response::json(
            [
                'data' => 'Insert to youtube was completed',
                'message' => '',
                'code' => ''
            ]
        )->withStatus(StatusCodeInterface::STATUS_OK);
    }
}