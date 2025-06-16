<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Client;

use App\Infrastructure\Imap\Assembler\MailAssembler;
use App\Infrastructure\Imap\DTO\GetMailIdsRequestDTO;
use App\Infrastructure\Imap\DTO\MailDTO;
use App\Infrastructure\Imap\Exception\ImapException;
use Exception;
use PhpImap\Mailbox;

class ImapClient implements ImapClientInterface
{
    public function __construct(
        private Mailbox $mailbox,
        private MailAssembler $mailAssembler
    ) {
    }

    /**
     * @throws ImapException
     */
    public function getMailIds(GetMailIdsRequestDTO $getMailIdsRequestDTO): array
    {
        try {
            $mailIds = $this->mailbox->sortMails(
                criteria: $getMailIdsRequestDTO->getSortCriteria()->value,
                searchCriteria: $getMailIdsRequestDTO->getSearchCriteria()->value
            );
        } catch (Exception $exception) {
            throw new ImapException($exception->getMessage());
        }

        return $mailIds;
    }

    /**
     * @throws ImapException
     */
    public function getMail(int $mailId): MailDTO
    {
        try {
            $incomingMail = $this->mailbox->getMail($mailId);
            $mailDTO = $this->mailAssembler->assembleFromIncomingMail($incomingMail);
        } catch (Exception $exception) {
            throw new ImapException($exception->getMessage());
        }

        return $mailDTO;
    }
}
