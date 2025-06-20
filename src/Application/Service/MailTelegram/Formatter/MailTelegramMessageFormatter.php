<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter;

use App\Application\Service\MailTelegram\Formatter\MessageBody\MailTelegramMessageBodyFormatterRegistry;
use App\Application\Service\MailTelegram\Formatter\MessageHeader\MailTelegramMessageHeaderFormatterInterface;
use App\Infrastructure\Imap\DTO\MailDTO;

class MailTelegramMessageFormatter implements MailTelegramMessageFormatterInterface
{
    public function __construct(
        private MailTelegramMessageHeaderFormatterInterface $headerFormatter,
        private MailTelegramMessageBodyFormatterRegistry $bodyFormatterRegistry
    ) {
    }

    public function format(MailDTO $mailDTO): string
    {
        $bodyFormatter = $this->bodyFormatterRegistry->getFormatter($mailDTO);

        return $this->headerFormatter->format($mailDTO->getMailHeaderDTO())
            . $bodyFormatter->format($mailDTO);
    }
}
