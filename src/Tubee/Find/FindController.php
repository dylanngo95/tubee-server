<?php

declare(strict_types=1);

namespace Tubee\Find;

use Fig\Http\Message\StatusCodeInterface;
use Framework\Config\Environment;
use Framework\Log\Logger;
use Framework\Log\Writer\Stream;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class FindController
 */
class FindController
{
    private FindRepository $repository;
    private Stream $stream;
    private Logger $logger;
    private Environment $environment;

    private $writer;

    /**
     * @param FindRepository $repository
     * @param Stream $stream
     * @param Logger $logger
     * @param Environment $environment
     */
    public function __construct(
        FindRepository $repository,
        Stream $stream,
        Logger $logger,
        Environment $environment
    ){
        $this->repository = $repository;
        $this->stream = $stream;
        $this->logger = $logger;
        $this->environment = $environment;
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');

        $logFolder = $this->environment->getLogPath();
        if (!$this->writer) {
            $this->writer = $this->stream->createWriter($logFolder . '/find.log');
            $this->logger = $this->logger->addWriter($this->writer);
        }
        $this->logger->write("Start Find ${id}");

        $youTubes = yield from $this->repository->findById($id);

        if (!$youTubes) {
            $this->logger->write("Error Find ${id}");
            return Response::json(
                [
                    'message' => "Not found ${id}"
                ]
            )->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $this->logger->write("End Find ${id}");

        $data = json_encode($youTubes);
        return Response::json(
            [
                'data' => $data,
                'message' => '',
                'code' => ''
            ]
        );
    }
}