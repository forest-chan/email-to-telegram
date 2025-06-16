<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\DTO;

use DateTimeInterface;

class MailHeaderDTO
{
    public function __construct(
        private ?string $fromAddress,
        private ?string $fromName,
        private ?string $to,
        private ?DateTimeInterface $date,
        private ?string $subject
    ) {}

    public function getFromAddress(): ?string
    {
        return $this->fromAddress;
    }

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function getTo(): ?string
    {
        return $this->to;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }
}
