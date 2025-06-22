<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller\MailTelegram;

use App\Application\Http\API\Assembler\MailTelegram\CreateMailTelegramRequestDTOAssembler;
use App\Application\Http\API\Controller\AbstractAPIController;
use App\Application\Http\API\Handler\MailTelegram\CreateMailTelegramHandler;
use App\Application\Http\API\Hydrator\Violation\ViolationListHydrator;
use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateMailTelegramController extends AbstractAPIController
{
    public function __invoke(
        Request $request,
        ValidatorInterface $validator,
        ViolationListHydrator $violationHydrator,
        CreateMailTelegramRequestDTOAssembler $requestDTOAssembler,
        CreateMailTelegramHandler $handler
    ): JsonResponse {
        try {
            $mailTelegramRequestDTO = $requestDTOAssembler->assemble(
                requestContent: $this->getRequestContentDecoded($request)
            );
            $violations = $validator->validate(
                value: $mailTelegramRequestDTO
            );

            if ($violations->count() > 0) {
                return $this->jsonResponse(
                    responseData: $violationHydrator->extract($violations),
                    statusCode: Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $handler->handle(
                requestDTO: $mailTelegramRequestDTO
            );

            return $this->jsonSuccessResponse();
        } catch (JsonException $exception) {
            $this->logger->error('Request deserialization failed on create mail telegram', [
                'method' => __METHOD__,
                'exception' => (string) $exception,
            ]);

            return $this->jsonFailResponse(Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            $this->logger->error('Unexpected error on create mail telegram', [
                'method' => __METHOD__,
                'exception' => (string) $exception,
            ]);

            return $this->jsonFailResponse();
        }
    }
}
