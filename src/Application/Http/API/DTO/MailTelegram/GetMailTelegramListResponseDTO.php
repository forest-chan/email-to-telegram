<?php

declare(strict_types=1);

namespace App\Application\Http\API\DTO\MailTelegram;

class GetMailTelegramListResponseDTO
{
    /** @var array<GetMailTelegramListItemResponseDTO> */
    private array $mailTelegramListItems = [];

    public function addMailTelegramListItem(GetMailTelegramListItemResponseDTO $itemResponseDTO): self
    {
        $this->mailTelegramListItems[] = $itemResponseDTO;

        return $this;
    }

    /** @return array<GetMailTelegramListItemResponseDTO> */
    public function getMailTelegramListItems(): array
    {
        return $this->mailTelegramListItems;
    }
}
