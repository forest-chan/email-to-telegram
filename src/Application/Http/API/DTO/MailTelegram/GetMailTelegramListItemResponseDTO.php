<?php

declare(strict_types=1);

namespace App\Application\Http\API\DTO\MailTelegram;

class GetMailTelegramListItemResponseDTO
{
    public function __construct(
        private int $id,
        private string $mailServerPath,
        private string $mail,
        private int $telegramChatId
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMailServerPath(): string
    {
        return $this->mailServerPath;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getTelegramChatId(): int
    {
        return $this->telegramChatId;
    }
}
