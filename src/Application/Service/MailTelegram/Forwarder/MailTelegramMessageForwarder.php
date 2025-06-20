<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Forwarder;

use App\Application\Service\Imap\Assembler\MailBoxDTOAssembler;
use App\Application\Service\Imap\Registry\ImapClientRegistry;
use App\Application\Service\MailTelegram\Formatter\MailTelegramMessageFormatterInterface;
use App\Application\Service\TelegramBot\Enum\TelegramBot;
use App\Application\Service\TelegramBot\Registry\TelegramBotClientRegistry;
use App\Domain\Entity\MailTelegram\MailTelegram;
use App\Infrastructure\Imap\Client\ImapClientInterface;
use App\Infrastructure\Imap\DTO\GetMailIdsRequestDTO;
use App\Infrastructure\Imap\Enum\SearchCriteria;
use App\Infrastructure\Imap\Enum\SortCriteria;
use App\Infrastructure\TelegramBot\DTO\SendMessageRequestDTO;
use App\Infrastructure\TelegramBot\Enum\ParseMode;

class MailTelegramMessageForwarder
{
    public function __construct(
        private MailBoxDTOAssembler $mailBoxDTOAssembler,
        private ImapClientRegistry $imapClientRegistry,
        private TelegramBotClientRegistry $telegramBotClientRegistry,
        private MailTelegramMessageFormatterInterface $mailTelegramMessageFormatter,
    ) {
    }

    public function forward(MailTelegram $mailTelegram): void
    {
        $telegramBotClient = $this->telegramBotClientRegistry->getTelegramBotClient(
            telegramBot: TelegramBot::MAIL_TELEGRAM_FORWARDER
        );
        $imapClient = $this->getImapClient(
            mailTelegram: $mailTelegram
        );

        $mailIds = $imapClient->getMailIds(new GetMailIdsRequestDTO(
            searchCriteria: SearchCriteria::UNSEEN,
            sortCriteria: SortCriteria::ARRIVAL_DATE
        ));

        foreach ($mailIds as $mailId) {
            $mailDTO = $imapClient->getMail($mailId);

            $telegramBotClient->sendMessage(new SendMessageRequestDTO(
                chatId: $mailTelegram->getTelegramChatId(),
                text: $this->mailTelegramMessageFormatter->format($mailDTO),
                parseMode: ParseMode::HTML,
            ));
        }
    }

    private function getImapClient(MailTelegram $mailTelegram): ImapClientInterface
    {
        return $this->imapClientRegistry->getImapClient(
            mailboxDTO: $this->mailBoxDTOAssembler->assemble($mailTelegram)
        );
    }
}
