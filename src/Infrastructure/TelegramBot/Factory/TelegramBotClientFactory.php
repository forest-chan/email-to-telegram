<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\Factory;

use App\Infrastructure\TelegramBot\Client\TelegramBotClient;
use App\Infrastructure\TelegramBot\Client\TelegramBotClientInterface;
use App\Infrastructure\TelegramBot\DTO\TelegramBotDTO;
use App\Infrastructure\TelegramBot\Exception\TelegramBotException;
use Psr\Log\LoggerInterface;
use Telegram\Bot\Api as TelegramBotAPI;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramBotClientFactory implements TelegramBotClientFactoryInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws TelegramBotException
     */
    public function create(TelegramBotDTO $telegramBotDTO): TelegramBotClientInterface
    {
        try {
            $telegramBotAPI = new TelegramBotAPI($telegramBotDTO->getTelegramBotToken());

            $telegramBotAPI->addCommands($telegramBotDTO->getCommands());
        } catch (TelegramSDKException $exception) {
            $this->logger->error(
                message: 'Failed to create telegram bot client',
                context: [
                    'method' => __METHOD__,
                    'exception' => (string) $exception,
                    'exceptionMessage' => $exception->getMessage(),
                ]
            );

            throw new TelegramBotException($exception->getMessage());
        }

        return new TelegramBotClient($telegramBotAPI);
    }
}
