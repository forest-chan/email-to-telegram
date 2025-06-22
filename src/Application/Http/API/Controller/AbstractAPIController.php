<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller;

use App\Application\Http\API\Hydrator\APIResponseHydrator;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractAPIController extends SymfonyController
{
    public function __construct(
        protected LoggerInterface $logger,
        protected APIResponseHydrator $apiResponseHydrator,
    ) {
    }

    /**
     * @throws JsonException
     */
    protected function getRequestContentDecoded(Request $request): array
    {
        return json_decode(
            json: $request->getContent(),
            associative: true,
            depth: 512,
            flags: JSON_THROW_ON_ERROR
        );
    }

    protected function jsonSuccessResponse(int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->jsonResponse(['success' => true], $statusCode);
    }

    protected function jsonFailResponse(int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->jsonResponse(['success' => false], $statusCode);
    }

    protected function jsonResponse(array $responseData, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->json(
            data: $this->apiResponseHydrator->extract($responseData),
            status: $statusCode,
        );
    }
}
