<?php

declare(strict_types=1);

namespace App\Application\Http\TelegramBot\Handler\Webhook;

use App\Application\Service\TelegramBot\Enum\TelegramBot;
use App\Application\Service\TelegramBot\Registry\TelegramBotClientRegistry;

class MailTelegramWebhookHandler
{
    public function __construct(
        private TelegramBotClientRegistry $telegramBotClientRegistry
    ) {
    }

    public function handle(): void
    {
        $telegramBotClient = $this->telegramBotClientRegistry->getTelegramBotClient(
            telegramBot: TelegramBot::MAIL_TELEGRAM_FORWARDER
        );

        $telegramBotClient->processCommands();
    }
}
