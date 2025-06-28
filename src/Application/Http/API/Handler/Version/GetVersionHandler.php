<?php

declare(strict_types=1);

namespace App\Application\Http\API\Handler\Version;

use App\Application\Http\API\DTO\Version\GetVersionResponseDTO;

class GetVersionHandler
{
    public function __construct(private string $version)
    {
    }

    public function handle(): GetVersionResponseDTO
    {
        return new GetVersionResponseDTO($this->version);
    }
}
