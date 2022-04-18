<?php

declare(strict_types=1);

namespace Tubee\Add;

use Fig\Http\Message\StatusCodeInterface;
use Framework\Log\Logger;
use Framework\Log\Writer\Stream;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class AddController
{
    /** @var AddRepository $addRepository */
    private $addRepository;

    /** @var Logger $logger */
    private $logger;

    /** @var Stream $stream */
    private $stream;

    public function __construct(
        AddRepository $addRepository,
        Stream $stream,
        Logger $logger
    ) {
        $this->addRepository = $addRepository;
        $this->stream = $stream;
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface $request
     * @return \RingCentral\Psr7\Response
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $writer = $this->stream->getWriter('add.log');
        $logger = $this->logger->addWriter($writer);

        $number = $request->getAttribute('number');
        $logger->write("Start Add ${number}");

        $this->addRepository->insertDumpData($number);

        $logger->write("End Add ${number}");

        return Response::json(
            [
                'data' => "Insert completed\n"
            ]
        )->withStatus(StatusCodeInterface::STATUS_OK);
    }
}