<?php

declare(strict_types=1);

namespace App\Application\Http\API\DTO\Version;

class GetVersionResponseDTO
{
    public function __construct(
        private string $apiVersion,
    ) {
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }
}
