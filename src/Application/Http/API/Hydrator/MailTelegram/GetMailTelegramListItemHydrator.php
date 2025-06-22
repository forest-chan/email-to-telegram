<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\MailTelegram;

use App\Application\Http\API\DTO\MailTelegram\GetMailTelegramListItemResponseDTO;

class GetMailTelegramListItemHydrator
{
    public function extract(GetMailTelegramListItemResponseDTO $itemResponseDTO): array
    {
        return [
            'id' => $itemResponseDTO->getId(),
            'mail_server_path' => $itemResponseDTO->getMailServerPath(),
            'mail' => $itemResponseDTO->getMail(),
            'telegram_chat_id' => $itemResponseDTO->getTelegramChatId(),
        ];
    }
}
