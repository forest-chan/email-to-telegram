<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\Factory;

use App\Infrastructure\TelegramBot\Client\TelegramBotClientInterface;
use App\Infrastructure\TelegramBot\DTO\TelegramBotDTO;

interface TelegramBotClientFactoryInterface
{
    public function create(TelegramBotDTO $telegramBotDTO): TelegramBotClientInterface;
}
