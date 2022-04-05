<?php

declare(strict_types=1);

namespace Tubee\Setup;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class SetupController
 */
class SetupController
{
    /**
     * @var SetupRepository $setupRepository
     */
    private $setupRepository;

    public function __construct(SetupRepository $setupRepository)
    {
        $this->setupRepository = $setupRepository;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $this->setupRepository->createInitTable();
//        $this->setupRepository->insertDumpData();
        return Response::json([
            'data' => 'init db completed'
        ]);
    }
}