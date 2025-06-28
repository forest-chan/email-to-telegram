<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller\MailTelegram;

use App\Application\Http\API\Controller\AbstractAPIController;
use App\Application\Http\API\Handler\MailTelegram\GetMailTelegramListHandler;
use App\Application\Http\API\Hydrator\MailTelegram\GetMailTelegramListHydrator;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetMailTelegramListController extends AbstractAPIController
{
    public function __invoke(
        Request $request,
        GetMailTelegramListHandler $handler,
        GetMailTelegramListHydrator $hydrator
    ): JsonResponse {
        try {
            $mailTelegramList = $handler->handle();

            return $this->jsonSuccessResponse($hydrator->extract($mailTelegramList), Response::HTTP_OK);
        } catch (Exception $exception) {
            $this->logger->error('Unexpected error on get mail telegram list', [
                'method' => __METHOD__,
                'exception' => (string) $exception,
            ]);

            return $this->jsonErrorResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
