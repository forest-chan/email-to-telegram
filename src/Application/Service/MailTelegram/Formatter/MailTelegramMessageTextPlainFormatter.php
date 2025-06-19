<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter;

use App\Infrastructure\Imap\DTO\MailDTO;

class MailTelegramMessageTextPlainFormatter implements MailTelegramMessageFormatterInterface
{
    public function __construct(
        private MailTelegramMessageHeaderFormatterInterface $headerFormatter,
    ) {
    }

    public function supports(MailDTO $mailDTO): bool
    {
        return $mailDTO->getTextPlain() !== null;
    }

    public function format(MailDTO $mailDTO): string
    {
        return $this->headerFormatter->format($mailDTO->getMailHeaderDTO()) . $mailDTO->getTextPlain();
    }
}
