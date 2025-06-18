<?php

declare(strict_types=1);

namespace App\Application\Service\Imap\Assembler;

use App\Domain\Entity\MailTelegram\MailTelegram;
use App\Infrastructure\Imap\DTO\MailboxDTO;

class MailBoxDTOAssembler
{
    public function assemble(MailTelegram $mailTelegram): MailBoxDTO
    {
        return new MailboxDTO(
            login: $mailTelegram->getMail(),
            imapPath: sprintf(
                "{%s}%s",
                $mailTelegram->getMailServerPath(),
                $mailTelegram->getMailDirectory()->value
            ),
            password: $mailTelegram->getPassword(),
            attachmentsDir: null,
            serverEncoding: $mailTelegram->getMailServerEncodingType()->value,
        );
    }
}
