<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter\MessageHeader;

use App\Infrastructure\Imap\DTO\MailHeaderDTO;

interface MailTelegramMessageHeaderFormatterInterface
{
    public function format(MailHeaderDTO $mailHeaderDTO): string;
}
