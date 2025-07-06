<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\Client;

use App\Infrastructure\TelegramBot\DTO\SendMessageRequestDTO;
use App\Infrastructure\TelegramBot\Exception\TelegramBotException;
use Psr\Log\LoggerInterface;

class TelegramBotClientLoggingDecorator implements TelegramBotClientInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private TelegramBotClientInterface $innerClient
    ) {
    }

    /**
     * @throws TelegramBotException
     */
    public function processCommands(): void
    {
        try {
            $this->innerClient->processCommands();
        } catch (TelegramBotException $exception) {
            $this->logger->error(
                message: 'Process telegram bot commands failed',
                context: [
                    'method' => __METHOD__,
                    'exception' => (string) $exception,
                    'exceptionMessage' => $exception->getMessage(),
                ]
            );

            throw $exception;
        }
    }

    /**
     * @throws TelegramBotException
     */
    public function sendMessage(SendMessageRequestDTO $sendMessageRequestDTO): void
    {
        $this->logger->info(
            message: 'Send message to Telegram bot',
            context: [
                'method' => __METHOD__,
                'parameters' => $sendMessageRequestDTO->toArray(),
            ]
        );

        try {
            $this->innerClient->sendMessage($sendMessageRequestDTO);
        } catch (TelegramBotException $exception) {
            $this->logger->error(
                message: 'Send message to Telegram bot failed',
                context: [
                    'method' => __METHOD__,
                    'exception' => (string) $exception,
                    'exceptionMessage' => $exception->getMessage(),
                ]
            );

            throw $exception;
        }
    }
}
