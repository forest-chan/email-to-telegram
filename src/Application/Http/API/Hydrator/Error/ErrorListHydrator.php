<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\Error;

use App\Application\Http\API\DTO\Error\ErrorListResponseDTO;

class ErrorListHydrator
{
    public function __construct(private ErrorListItemHydrator $itemHydrator)
    {
    }

    public function extract(ErrorListResponseDTO $errorListResponseDTO): array
    {
        $extractedErrors = [];

        foreach ($errorListResponseDTO->getErrorListItems() as $errorItem) {
            $extractedErrors[] = $this->itemHydrator->extract($errorItem);
        }

        return [
            'errors' => $extractedErrors,
        ];
    }
}
