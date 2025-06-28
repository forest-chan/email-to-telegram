<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller\Version;

use App\Application\Http\API\Controller\AbstractAPIController;
use App\Application\Http\API\Handler\Version\GetVersionHandler;
use App\Application\Http\API\Hydrator\Version\GetVersionHydrator;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetVersionController extends AbstractAPIController
{
    public function __invoke(
        GetVersionHandler $handler,
        GetVersionHydrator $hydrator
    ): JsonResponse {
        try {
            $apiVersionResponseDTO = $handler->handle();

            return $this->jsonSuccessResponse($hydrator->extract($apiVersionResponseDTO), Response::HTTP_OK);
        } catch (Exception $exception) {
            $this->logger->error('Unexpected error on get version', [
                'method' => __METHOD__,
                'exception' => (string) $exception,
            ]);

            return $this->jsonErrorResponse([self::INTERNAL_SERVER_ERROR_ERROR_MESSAGE], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
