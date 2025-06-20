<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter\MessageHeader;

use App\Infrastructure\Imap\DTO\MailHeaderDTO;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class MailTelegramMessageHeaderFormatter implements MailTelegramMessageHeaderFormatterInterface
{
    public function __construct(
        private HtmlSanitizerInterface $htmlTagSymbolsSanitizer,
    ) {
    }

    public function format(MailHeaderDTO $mailHeaderDTO): string
    {
        $formattedHeaderText = sprintf(
            "<b>Тема письма:</b> %s\n\r<b>Отправитель:</b> %s (%s)\n\r<b>Получатель:</b> %s \n\r<b>Дата письма:</b> %s \n\r",
            $mailHeaderDTO->getSubject() ?? '',
            $mailHeaderDTO->getFromName() ?? '',
            $mailHeaderDTO->getFromAddress() ?? '',
            $this->htmlTagSymbolsSanitizer->sanitize($mailHeaderDTO->getTo() ?? ''),
            $mailHeaderDTO->getDate()?->format('d.m.Y H:i:s') ?? '',
        );

        return $formattedHeaderText . PHP_EOL;
    }
}
