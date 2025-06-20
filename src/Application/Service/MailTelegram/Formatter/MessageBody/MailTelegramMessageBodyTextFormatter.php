<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter\MessageBody;

use App\Infrastructure\Imap\DTO\MailDTO;

class MailTelegramMessageBodyTextFormatter implements MailTelegramMessageBodyFormatterInterface
{
    public function supports(MailDTO $mailDTO): bool
    {
        return $mailDTO->getTextPlain() !== null;
    }

    public function format(MailDTO $mailDTO): string
    {
        return $mailDTO->getTextPlain();
    }
}
