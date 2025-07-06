<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\Client;

use App\Infrastructure\TelegramBot\DTO\SendMessageRequestDTO;
use App\Infrastructure\TelegramBot\Exception\TelegramBotException;
use Telegram\Bot\Api as TelegramBotAPI;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramBotClient implements TelegramBotClientInterface
{
    public function __construct(
        private TelegramBotAPI $telegramBotAPI
    ) {
    }

    /**
     * @throws TelegramBotException
     */
    public function processCommands(): void
    {
        try {
            $this->telegramBotAPI->commandsHandler(true);
        } catch (TelegramSDKException $exception) {
            throw new TelegramBotException($exception->getMessage());
        }
    }

    /**
     * @throws TelegramBotException
     */
    public function sendMessage(SendMessageRequestDTO $sendMessageRequestDTO): void
    {
        try {
            $this->telegramBotAPI->sendMessage($sendMessageRequestDTO->toArray());
        } catch (TelegramSDKException $exception) {
            throw new TelegramBotException($exception->getMessage());
        }
    }
}
