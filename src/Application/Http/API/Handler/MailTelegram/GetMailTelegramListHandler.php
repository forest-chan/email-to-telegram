<?php

declare(strict_types=1);

namespace App\Application\Http\API\Handler\MailTelegram;

use App\Application\Http\API\DTO\MailTelegram\GetMailTelegramListItemResponseDTO;
use App\Application\Http\API\DTO\MailTelegram\GetMailTelegramListResponseDTO;
use App\Domain\Repository\MailTelegram\MailTelegramRepositoryInterface;

class GetMailTelegramListHandler
{
    public function __construct(
        private MailTelegramRepositoryInterface $mailTelegramRepository,
    ) {
    }

    public function handle(): GetMailTelegramListResponseDTO
    {
        $mailTelegramList = new GetMailTelegramListResponseDTO();

        foreach ($this->mailTelegramRepository->findAll() as $mailTelegram) {
            $mailTelegramListItem = new GetMailTelegramListItemResponseDTO(
                id: $mailTelegram->getId(),
                mailServerPath: $mailTelegram->getMailServerPath(),
                mail: $mailTelegram->getMail(),
                telegramChatId: $mailTelegram->getTelegramChatId()
            );

            $mailTelegramList->addMailTelegramListItem($mailTelegramListItem);
        }

        return $mailTelegramList;
    }
}
