<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter\MessageBody;

use App\Infrastructure\Imap\DTO\MailDTO;

interface MailTelegramMessageBodyFormatterInterface
{
    public function supports(MailDTO $mailDTO): bool;
    public function format(MailDTO $mailDTO): string;
}
