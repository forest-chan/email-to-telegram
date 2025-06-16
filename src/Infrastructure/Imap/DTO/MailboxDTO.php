<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\DTO;

class MailboxDTO
{
    public function __construct(
        private string $login,
        private string $imapPath,
        private string $password,
        private ?string $attachmentsDir,
        private string $serverEncoding
    ) {
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getImapPath(): string
    {
        return $this->imapPath;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAttachmentsDir(): ?string
    {
        return $this->attachmentsDir;
    }

    public function getServerEncoding(): string
    {
        return $this->serverEncoding;
    }
}
