<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\DTO;

class MailDTO
{
    public function __construct(
        private MailHeaderDTO $mailHeaderDTO,
        private ?string $textPlain,
        private ?string $textHtml
    ) {
    }

    public function getMailHeaderDTO(): MailHeaderDTO
    {
        return $this->mailHeaderDTO;
    }

    public function getTextPlain(): ?string
    {
        return $this->textPlain;
    }

    public function getTextHtml(): ?string
    {
        return $this->textHtml;
    }
}

