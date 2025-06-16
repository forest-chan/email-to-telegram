<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter;

use App\Infrastructure\Imap\DTO\MailDTO;

class MailTelegramMessageFormatter implements MailTelegramMessageFormatterInterface
{
    private const DEFAULT_NEW_LINE = PHP_EOL;
    private const DEFAULT_DATE_FORMAT = 'Y-m-d H:i:s';
    private const DEFAULT_FORMATTED_MESSAGE_PATTERN = '
    Новое письмо%s
    Тема: %s%s
    Отправитель: %s (%s)%s
    Получатель: %s%s
    Дата письма: %s';

    public function format(MailDTO $mailDTO): string
    {
        return sprintf(
            self::DEFAULT_FORMATTED_MESSAGE_PATTERN,
            self::DEFAULT_NEW_LINE,
            $mailDTO->getMailHeaderDTO()->getSubject() ?? '',
            self::DEFAULT_NEW_LINE,
            $mailDTO->getMailHeaderDTO()->getFromAddress() ?? '',
            $mailDTO->getMailHeaderDTO()->getFromName() ?? '',
            self::DEFAULT_NEW_LINE,
            $mailDTO->getMailHeaderDTO()->getTo() ?? '',
            self::DEFAULT_NEW_LINE,
            $mailDTO->getMailHeaderDTO()->getDate()?->format(self::DEFAULT_DATE_FORMAT) ?? '',
        );
    }
}
