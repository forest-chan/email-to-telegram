<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Factory;

use App\Infrastructure\Imap\Assembler\MailAssembler;
use App\Infrastructure\Imap\Client\ImapClient;
use App\Infrastructure\Imap\Client\ImapClientInterface;
use App\Infrastructure\Imap\DTO\MailboxDTO;
use App\Infrastructure\Imap\Exception\ImapException;
use PhpImap\Exceptions\InvalidParameterException;
use PhpImap\Mailbox;
use Psr\Log\LoggerInterface;

class ImapClientFactory implements ImapClientFactoryInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private MailAssembler $mailAssembler,
    ) {
    }

    /**
     * @throws ImapException
     */
    public function create(MailboxDTO $mailboxDTO): ImapClientInterface
    {
        try {
            $mailbox = new Mailbox(
                imapPath: $mailboxDTO->getImapPath(),
                login: $mailboxDTO->getLogin(),
                password: $mailboxDTO->getPassword(),
                attachmentsDir: $mailboxDTO->getAttachmentsDir(),
                serverEncoding: $mailboxDTO->getServerEncoding()
            );

            return new ImapClient(
                mailbox: $mailbox,
                mailAssembler: $this->mailAssembler
            );
        } catch (InvalidParameterException $exception) {
            $this->logger->error(
                message: 'Failed to create imap client',
                context: [
                    'method' => __METHOD__,
                    'exception' => (string) $exception,
                    'exceptionMessage' => $exception->getMessage(),
                ]
            );

            throw new ImapException($exception->getMessage());
        }
    }
}
