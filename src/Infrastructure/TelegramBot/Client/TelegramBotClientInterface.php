<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\Client;

use App\Infrastructure\TelegramBot\DTO\SendMessageRequestDTO;

interface TelegramBotClientInterface
{
    public function sendMessage(SendMessageRequestDTO $sendMessageRequestDTO): void;
}
