<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller;

use App\Application\Http\API\Hydrator\Violation\ViolationHydrator;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractAPIController extends SymfonyController
{
    public function __construct(
        protected ValidatorInterface $validator,
        protected ViolationHydrator $violationHydrator,
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

    protected function jsonSuccessResponse(): JsonResponse
    {
        return $this->json(['success' => true], Response::HTTP_OK);
    }

    protected function jsonErrorResponse(mixed $data, int $statusCode): JsonResponse
    {
        $extractedData = [];

        if ($data instanceof ConstraintViolationListInterface) {
            $extractedData = $this->violationHydrator->extract($data);
        }

        return $this->json($extractedData, $statusCode);
    }
}
