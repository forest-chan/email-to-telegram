<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller\Version;

use App\Application\Http\API\Controller\AbstractAPIController;
use App\Application\Http\API\Handler\Version\GetVersionHandler;
use App\Application\Http\API\Hydrator\Version\GetVersionHydrator;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetVersionController extends AbstractAPIController
{
    public function __invoke(
        GetVersionHandler $handler,
        GetVersionHydrator $hydrator
    ): JsonResponse {
        $apiVersionResponseDTO = $handler->handle();

        return $this->json($hydrator->extract($apiVersionResponseDTO));
    }
}
