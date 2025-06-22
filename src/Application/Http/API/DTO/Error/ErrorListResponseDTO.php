<?php

declare(strict_types=1);

namespace App\Application\Http\API\DTO\Error;

class ErrorListResponseDTO
{
    /** @var array<ErrorListItemResponseDTO> */
    private array $errorListItems = [];

    public function addErrorListItem(ErrorListItemResponseDTO $errorListItemResponseDTO): self
    {
        $this->errorListItems[] = $errorListItemResponseDTO;

        return $this;
    }

    public function getErrorListItems(): array
    {
        return $this->errorListItems;
    }
}
