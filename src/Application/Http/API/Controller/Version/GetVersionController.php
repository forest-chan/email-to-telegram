<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller\Version;

use App\Application\Http\API\Handler\Version\GetVersionHandler;
use App\Application\Http\API\Hydrator\Version\GetVersionHydrator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetVersionController extends AbstractController
{
    public function __invoke(
        GetVersionHandler $handler,
        GetVersionHydrator $hydrator
    ): JsonResponse {
        $apiVersionResponse = $handler->handle();

        return $this->json($hydrator->hydrate($apiVersionResponse));
    }
}
