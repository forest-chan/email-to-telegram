<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Factory;

use App\Infrastructure\Imap\Client\ImapClientInterface;
use App\Infrastructure\Imap\DTO\MailboxDTO;

interface ImapClientFactoryInterface
{
    public function create(MailboxDTO $mailboxDTO): ImapClientInterface;
}
