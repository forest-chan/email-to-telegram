<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Client;

use App\Infrastructure\Imap\DTO\GetMailIdsRequestDTO;
use App\Infrastructure\Imap\DTO\MailDTO;

interface ImapClientInterface
{
    /** @return array<int> */
    public function getMailIds(GetMailIdsRequestDTO $getMailIdsRequestDTO): array;
    public function getMail(int $mailId): MailDTO;
}
