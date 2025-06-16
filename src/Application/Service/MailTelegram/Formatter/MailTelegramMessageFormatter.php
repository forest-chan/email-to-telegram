<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter;

use App\Infrastructure\Imap\DTO\MailDTO;

class MailTelegramMessageFormatter implements MailTelegramMessageFormatterInterface
{
    public function format(MailDTO $mailDTO): string
    {
        return $mailDTO->getTextPlain() ?? '';
    }
}
