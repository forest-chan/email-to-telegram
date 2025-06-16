<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\DTO;

class SendMessageRequestDTO extends RequestDTO
{
    public function __construct(
        private int $chatId,
        private string $text,
    ) {
    }

    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId,
            'text' => $this->text,
        ];
    }
}
