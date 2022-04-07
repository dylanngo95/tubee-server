<?php

declare(strict_types=1);

namespace Tubee\Add;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class AddController
{
    /** @var AddRepository $addRepository */
    private $addRepository;

    public function __construct(AddRepository $addRepository)
    {
        $this->addRepository = $addRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @return \RingCentral\Psr7\Response
     */
    public function __invoke(ServerRequestInterface $request): \RingCentral\Psr7\Response
    {
        $number = $request->getAttribute('number');
        $insertNumber = $this->addRepository->insertDumpData($number);

        if ($insertNumber === null) {
            return Response::json(
                [
                    'data' => "Insert completed\n"
                ]
            )->withStatus(StatusCodeInterface::STATUS_OK);
        }
    }
}