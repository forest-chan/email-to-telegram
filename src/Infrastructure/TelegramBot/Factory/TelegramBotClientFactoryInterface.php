<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\Factory;

use App\Infrastructure\TelegramBot\Client\TelegramBotClientInterface;

interface TelegramBotClientFactoryInterface
{
    public function create(string $telegramBotToken): TelegramBotClientInterface;
}
