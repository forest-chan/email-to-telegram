<?php

declare(strict_types=1);

namespace App\Application\Service\Imap\Registry;

use App\Infrastructure\Imap\Client\ImapClientInterface;
use App\Infrastructure\Imap\DTO\MailboxDTO;
use App\Infrastructure\Imap\Factory\ImapClientFactoryInterface;

class ImapClientRegistry
{
    /** @var array<string, ImapClientInterface> $imapClients */
    private array $imapClients = [];

    public function __construct(
        private ImapClientFactoryInterface $imapClientFactory
    ) {
    }

    public function getImapClient(MailboxDTO $mailboxDTO): ImapClientInterface
    {
        $imapClientKey = $this->getImapClientKey($mailboxDTO);

        $imapClient = $this->imapClients[$imapClientKey] ?? null;

        if (!$imapClient instanceof ImapClientInterface) {
            $this->imapClients[$imapClientKey] = $this->imapClientFactory->create(
                mailboxDTO: $mailboxDTO,
            );
        }

        return $this->imapClients[$imapClientKey];
    }

    private function getImapClientKey(MailboxDTO $mailboxDTO): string
    {
        return sprintf('%s_%s', $mailboxDTO->getImapPath(), $mailboxDTO->getLogin());
    }
}
