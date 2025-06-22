<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller;

use App\Application\Http\API\DTO\Error\ErrorListItemResponseDTO;
use App\Application\Http\API\DTO\Error\ErrorListResponseDTO;
use App\Application\Http\API\Hydrator\APIResponseHydrator;
use App\Application\Http\API\Hydrator\Error\ErrorListHydrator;
use App\Application\Service\Auth\TokenAuthenticatorInterface;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractAPIController extends SymfonyController
{
    private const X_API_TOKEN_HEADER = 'X-API-Token';

    public function __construct(
        protected LoggerInterface $logger,
        protected ErrorListHydrator $errorListHydrator,
        protected APIResponseHydrator $apiResponseHydrator,
        protected TokenAuthenticatorInterface $tokenAuthenticator,
    ) {
    }

    protected function isAuthenticated(Request $request): bool
    {
        $APIToken = $request->headers->get(self::X_API_TOKEN_HEADER);

        if ($APIToken === null) {
            return false;
        }

        return $this->tokenAuthenticator->authenticate($APIToken);
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

    protected function jsonUnauthorizedResponse(): JsonResponse
    {
        $errorList = (new ErrorListResponseDTO())
            ->addErrorListItem(new ErrorListItemResponseDTO('Unauthorized'));

        return $this->jsonResponse(
            responseData: $this->errorListHydrator->extract($errorList),
            statusCode: Response::HTTP_UNAUTHORIZED
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
