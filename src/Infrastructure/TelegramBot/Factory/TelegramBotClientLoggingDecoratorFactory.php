<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\Factory;

use App\Infrastructure\TelegramBot\Client\TelegramBotClientInterface;
use App\Infrastructure\TelegramBot\Client\TelegramBotClientLoggingDecorator;
use Psr\Log\LoggerInterface;

class TelegramBotClientLoggingDecoratorFactory implements TelegramBotClientFactoryInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private TelegramBotClientFactoryInterface $innerClientFactory
    ) {
    }

    public function create(string $telegramBotToken): TelegramBotClientInterface
    {
        $innerClient = $this->innerClientFactory->create($telegramBotToken);

        return new TelegramBotClientLoggingDecorator($this->logger, $innerClient);
    }
}
