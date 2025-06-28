<?php

declare(strict_types=1);

namespace App\Application\Http\API\DTO\Version;

class GetVersionResponseDTO
{
    public function __construct(
        private string $version,
    ) {
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}
