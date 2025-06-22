<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller\MailTelegram;

use App\Application\Http\API\Assembler\MailTelegram\CreateMailTelegramRequestDTOAssembler;
use App\Application\Http\API\Controller\AbstractAPIController;
use App\Application\Http\API\Handler\MailTelegram\CreateMailTelegramHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateMailTelegramController extends AbstractAPIController
{
    public function __invoke(
        Request $request,
        CreateMailTelegramRequestDTOAssembler $requestDTOAssembler,
        CreateMailTelegramHandler $handler
    ): JsonResponse {
        $mailTelegramRequestDTO = $requestDTOAssembler->assemble(
            requestContent: $this->getRequestContentDecoded($request)
        );
        $violations = $this->validator->validate($mailTelegramRequestDTO);

        if ($violations->count() > 0) {
            return $this->jsonErrorResponse(
                data: $violations,
                statusCode: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $handler->handle($mailTelegramRequestDTO);

        return $this->jsonSuccessResponse();
    }
}
