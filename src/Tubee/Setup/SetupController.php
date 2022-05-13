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
    private SetupRepository $setupRepository;

    /**
     * @param SetupRepository $setupRepository
     */
    public function __construct(SetupRepository $setupRepository)
    {
        $this->setupRepository = $setupRepository;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $this->setupRepository->createInitTable();
        return Response::json([
            'data' => 'Database has initialize'
        ]);
    }
}