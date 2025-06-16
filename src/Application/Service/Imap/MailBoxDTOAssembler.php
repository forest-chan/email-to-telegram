<?php

declare(strict_types=1);

namespace App\Application\Service\Imap;

use App\Domain\Entity\MailTelegramUser\MailTelegramUser;
use App\Infrastructure\Imap\DTO\MailboxDTO;

class MailBoxDTOAssembler
{
    public function assemble(MailTelegramUser $mailTelegramUser): MailBoxDTO
    {
        return new MailboxDTO(
            login: $mailTelegramUser->getMail(),
            imapPath: sprintf(
                "{%s}%s",
                $mailTelegramUser->getMailServerPath(),
                $mailTelegramUser->getMailDirectory()->value
            ),
            password: $mailTelegramUser->getPassword(),
            attachmentsDir: null,
            serverEncoding: $mailTelegramUser->getMailServerEncodingType()->value,
        );
    }
}
