<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\Version;

use App\Application\Http\API\DTO\Version\GetVersionResponseDTO;

class GetVersionHydrator
{
    public function extract(GetVersionResponseDTO $getVersionResponseDTO): array
    {
        return [
            'api_version' => $getVersionResponseDTO->getAPIVersion(),
        ];
    }
}
