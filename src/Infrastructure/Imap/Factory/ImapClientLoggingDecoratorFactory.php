<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Factory;

use App\Infrastructure\Imap\Client\ImapClientInterface;
use App\Infrastructure\Imap\Client\ImapClientLoggingDecorator;
use App\Infrastructure\Imap\DTO\MailboxDTO;
use Psr\Log\LoggerInterface;

class ImapClientLoggingDecoratorFactory implements ImapClientFactoryInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private ImapClientFactoryInterface $innerClientFactory
    ) {
    }

    public function create(MailboxDTO $mailboxDTO): ImapClientInterface
    {
        $innerClient = $this->innerClientFactory->create($mailboxDTO);

        return new ImapClientLoggingDecorator($this->logger, $innerClient);
    }
}
