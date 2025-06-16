<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Forwarder;

use App\Application\Service\Imap\MailBoxDTOAssembler;
use App\Application\Service\MailTelegram\Formatter\MailTelegramMessageFormatterInterface;
use App\Domain\Entity\MailTelegramUser\MailTelegramUser;
use App\Infrastructure\Imap\Client\ImapClientInterface;
use App\Infrastructure\Imap\DTO\GetMailIdsRequestDTO;
use App\Infrastructure\Imap\Enum\SearchCriteria;
use App\Infrastructure\Imap\Enum\SortCriteria;
use App\Infrastructure\Imap\Factory\ImapClientFactoryInterface;
use App\Infrastructure\TelegramBot\Client\TelegramBotClientInterface;
use App\Infrastructure\TelegramBot\DTO\SendMessageRequestDTO;
use App\Infrastructure\TelegramBot\Factory\TelegramBotClientFactoryInterface;

class MailTelegramMessageForwarder
{
    private TelegramBotClientInterface $telegramBotClient;

    public function __construct(
        private string $telegramBotToken,
        private MailBoxDTOAssembler $mailBoxDTOAssembler,
        private ImapClientFactoryInterface $imapClientFactory,
        private TelegramBotClientFactoryInterface $telegramBotClientFactory,
        private MailTelegramMessageFormatterInterface $mailTelegramMessageFormatter,
    ) {
        $this->telegramBotClient = $this->telegramBotClientFactory->create($this->telegramBotToken);
    }

    public function forward(MailTelegramUser $mailTelegramUser): void
    {
        $imapClient = $this->getImapClient($mailTelegramUser);

        $mailIds = $imapClient->getMailIds(new GetMailIdsRequestDTO(
            searchCriteria: SearchCriteria::UNSEEN,
            sortCriteria: SortCriteria::ARRIVAL_DATE
        ));

        foreach ($mailIds as $mailId) {
            $mailDTO = $imapClient->getMail($mailId);

            $this->telegramBotClient->sendMessage(new SendMessageRequestDTO(
                chatId: $mailTelegramUser->getTelegramChatId(),
                text: $this->mailTelegramMessageFormatter->format($mailDTO),
            ));
        }
    }

    private function getImapClient(MailTelegramUser $mailTelegramUser): ImapClientInterface
    {
        $mailboxDTO = $this->mailBoxDTOAssembler->assemble($mailTelegramUser);

        return $this->imapClientFactory->create($mailboxDTO);
    }
}
