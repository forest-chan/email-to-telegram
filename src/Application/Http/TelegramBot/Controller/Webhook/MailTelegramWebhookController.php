<?php

declare(strict_types=1);

namespace App\Application\Http\TelegramBot\Controller\Webhook;

use App\Application\Http\TelegramBot\Controller\TelegramBotAbstractController;
use App\Application\Http\TelegramBot\Handler\Webhook\MailTelegramWebhookHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class MailTelegramWebhookController extends TelegramBotAbstractController
{
    public function __invoke(MailTelegramWebhookHandler $handler): JsonResponse
    {
        try {
            $handler->handle();

            return $this->jsonSuccessResponse();
        } catch (Throwable $exception) {
            $this->logger->error("Unexpected error on process mail telegram webhook from telegram bot", [
                'method' => __METHOD__,
                'exception' => (string) $exception,
            ]);

            return $this->jsonErrorResponse();
        }
    }
}
