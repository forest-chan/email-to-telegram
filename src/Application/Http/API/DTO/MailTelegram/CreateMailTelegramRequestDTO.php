<?php

declare(strict_types=1);

namespace App\Application\Http\API\DTO\MailTelegram;

use Symfony\Component\Validator\Constraints as Assert;

class CreateMailTelegramRequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public string $mailServerPath;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[Assert\Email]
    public string $mail;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public string $password;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\Range(min: 1)]
    public int $telegramChatId;

    public function __construct(
        string $mailServerPath,
        string $mail,
        string $password,
        int $telegramChatId
    ) {
        $this->mailServerPath = $mailServerPath;
        $this->mail = $mail;
        $this->password = $password;
        $this->telegramChatId = $telegramChatId;
    }

    public function getMailServerPath(): string
    {
        return $this->mailServerPath;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getTelegramChatId(): int
    {
        return $this->telegramChatId;
    }
}
