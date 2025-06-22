<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\MailTelegram;

use App\Application\Http\API\DTO\MailTelegram\GetMailTelegramListResponseDTO;

class GetMailTelegramListHydrator
{
    public function __construct(private GetMailTelegramListItemHydrator $itemHydrator)
    {
    }

    public function extract(GetMailTelegramListResponseDTO $listResponseDTO): array
    {
        $extractedItems = [];

        foreach ($listResponseDTO->getMailTelegramListItems() as $item) {
            $extractedItems[] = $this->itemHydrator->extract($item);
        }

        return [
            'items' => $extractedItems,
        ];
    }
}
