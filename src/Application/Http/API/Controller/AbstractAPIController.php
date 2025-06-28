<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller;

use App\Application\Http\API\Assembler\Error\ErrorListAssembler;
use App\Application\Http\API\DTO\Error\ErrorListResponseDTO;
use App\Application\Http\API\Hydrator\APIResponseHydrator;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractAPIController extends SymfonyController
{
    protected const BAD_REQUEST_ERROR_MESSAGE = 'Bad request';
    protected const INTERNAL_SERVER_ERROR_ERROR_MESSAGE = 'Internal server error';

    public function __construct(
        protected LoggerInterface $logger,
        private ErrorListAssembler $errorListAssembler,
        private APIResponseHydrator $apiResponseHydrator
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

    protected function jsonErrorResponse(mixed $errors, int $statusCode): JsonResponse
    {
        $errorListResponseDTO = $errors instanceof ConstraintViolationListInterface
            ? $this->errorListAssembler->assembleFromViolationList($errors)
            : $this->errorListAssembler->assembleFromErrorMessages($errors);

        return $this->jsonResponse(
            responseData: [],
            statusCode: $statusCode,
            success: false,
            errorListResponseDTO: $errorListResponseDTO
        );
    }

    protected function jsonSuccessResponse(array $responseData, int $statusCode): JsonResponse
    {
        return $this->jsonResponse(
            responseData: $responseData,
            statusCode: $statusCode,
            success: true,
            errorListResponseDTO: null
        );
    }

    private function jsonResponse(
        array $responseData,
        int $statusCode,
        bool $success,
        ?ErrorListResponseDTO $errorListResponseDTO
    ): JsonResponse {
        return $this->json(
            data: $this->apiResponseHydrator->extract($responseData, $success, $errorListResponseDTO),
            status: $statusCode,
        );
    }
}
