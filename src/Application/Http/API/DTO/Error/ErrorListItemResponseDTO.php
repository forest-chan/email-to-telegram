<?php

declare(strict_types=1);

namespace App\Application\Http\API\DTO\Error;

class ErrorListItemResponseDTO
{
    public function __construct(
        private string $message
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
