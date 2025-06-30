<?php

declare(strict_types=1);

namespace App\Application\Http\API\Handler\MailTelegram;

use App\Application\Http\API\DTO\MailTelegram\CreateMailTelegramRequestDTO;
use App\Domain\Entity\MailTelegram\MailTelegram;
use App\Domain\Enum\EncodingType;
use App\Domain\Enum\MailDirectory;
use App\Domain\Repository\MailTelegram\MailTelegramRepositoryInterface;

class CreateMailTelegramHandler
{
    public function __construct(
        private MailTelegramRepositoryInterface $mailTelegramRepository
    ) {
    }

    public function handle(CreateMailTelegramRequestDTO $requestDTO): void
    {
        $mailTelegram = new MailTelegram(
            mailServerPath: $requestDTO->getMailServerPath(),
            mail: $requestDTO->getMail(),
            password: $requestDTO->getPassword(),
            mailDirectory: MailDirectory::INBOX,
            mailServerEncodingType: EncodingType::UTF8,
            telegramChatId: $requestDTO->getTelegramChatId(),
        );

        $this->mailTelegramRepository->save($mailTelegram);
    }
}
