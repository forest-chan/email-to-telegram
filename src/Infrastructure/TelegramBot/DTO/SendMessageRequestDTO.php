<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\DTO;

use App\Infrastructure\TelegramBot\Enum\ParseMode;

class SendMessageRequestDTO extends RequestDTO
{
    public function __construct(
        private int $chatId,
        private string $text,
        private ParseMode $parseMode,
    ) {
    }

    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId,
            'text' => $this->text,
            'parse_mode' => $this->parseMode->value
        ];
    }
}
