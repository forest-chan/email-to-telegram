<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter\MessageBody;

use App\Infrastructure\Imap\DTO\MailDTO;
use RuntimeException;

class MailTelegramMessageBodyFormatterRegistry
{
    /** @param iterable<MailTelegramMessageBodyFormatterInterface> $formatters */
    public function __construct(
        private iterable $formatters,
    ) {
    }

    public function getFormatter(MailDTO $mailDTO): MailTelegramMessageBodyFormatterInterface
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->supports($mailDTO)) {
                return $formatter;
            }
        }

        throw new RuntimeException("Mail telegram message body formatter not found");
    }
}
