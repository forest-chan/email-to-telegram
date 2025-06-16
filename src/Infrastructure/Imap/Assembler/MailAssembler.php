<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Assembler;

use App\Infrastructure\Imap\DTO\MailDTO;
use App\Infrastructure\Imap\DTO\MailHeaderDTO;
use DateMalformedStringException;
use DateTime;
use PhpImap\IncomingMail;

class MailAssembler
{
    /**
     * @throws DateMalformedStringException
     */
    public function assembleFromIncomingMail(IncomingMail $mail): MailDTO
    {
        $headerDTO = new MailHeaderDTO(
            fromAddress: $mail->fromAddress,
            fromName: $mail->fromName,
            to: $mail->toString,
            date: $mail->date !== null ? new DateTime($mail->date) : null,
            subject: $mail->subject,
        );

        return new MailDTO(
            mailHeaderDTO: $headerDTO,
            textPlain: $mail->textPlain,
            textHtml: $mail->textHtml,
        );
    }
}
