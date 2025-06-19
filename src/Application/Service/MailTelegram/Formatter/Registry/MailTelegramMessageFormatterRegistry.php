<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter\Registry;

use App\Application\Service\MailTelegram\Formatter\MailTelegramMessageFormatterInterface;
use App\Infrastructure\Imap\DTO\MailDTO;
use RuntimeException;

class MailTelegramMessageFormatterRegistry
{
    /** @param iterable<MailTelegramMessageFormatterInterface> $formatters */
    public function __construct(
        private iterable $formatters,
    ) {
    }

    public function getFormatter(MailDTO $mailDTO): MailTelegramMessageFormatterInterface
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->supports($mailDTO)) {
                return $formatter;
            }
        }

        throw new RuntimeException("Mail telegram message formatter not found");
    }
}
