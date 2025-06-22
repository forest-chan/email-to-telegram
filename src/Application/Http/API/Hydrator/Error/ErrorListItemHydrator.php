<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\Error;

use App\Application\Http\API\DTO\Error\ErrorListItemResponseDTO;

class ErrorListItemHydrator
{
    public function extract(ErrorListItemResponseDTO $itemResponseDTO): array
    {
        return [
            'message' => $itemResponseDTO->getMessage(),
        ];
    }
}
