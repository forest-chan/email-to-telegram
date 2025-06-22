<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller\Version;

use App\Application\Http\API\Controller\AbstractAPIController;
use App\Application\Http\API\Handler\Version\GetVersionHandler;
use App\Application\Http\API\Hydrator\Version\GetVersionHydrator;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetVersionController extends AbstractAPIController
{
    public function __invoke(
        GetVersionHandler $handler,
        GetVersionHydrator $hydrator
    ): JsonResponse {
        try {
            $apiVersionResponseDTO = $handler->handle();

            return $this->jsonResponse($hydrator->extract($apiVersionResponseDTO));
        } catch (Exception $exception) {
            $this->logger->error('Unexpected error on get api version', [
                'method' => __METHOD__,
                'exception' => (string) $exception,
            ]);

            return $this->jsonFailResponse();
        }
    }
}
