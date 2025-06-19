<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter;

use App\Infrastructure\Imap\DTO\MailHeaderDTO;

class MailTelegramMessageHeaderFormatter implements MailTelegramMessageHeaderFormatterInterface
{
    public function format(MailHeaderDTO $mailHeaderDTO): string
    {
        $to = str_replace(['<', '>'], ['(', ')'], $mailHeaderDTO->getTo() ?? '');
        $formattedHeaderText = sprintf(
            "<b>Тема письма:</b> %s\n\r<b>Отправитель:</b> %s (%s)\n\r<b>Получатель:</b> %s \n\r<b>Дата письма:</b> %s \n\r",
            $mailHeaderDTO->getSubject() ?? '',
            $mailHeaderDTO->getFromName() ?? '',
            $mailHeaderDTO->getFromAddress() ?? '',
            $to,
            $mailHeaderDTO->getDate()?->format('d.m.Y H:i:s') ?? '',
        );

        return $formattedHeaderText . PHP_EOL;
    }
}
