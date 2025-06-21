<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\Version;

use App\Application\Http\API\Response\Version\GetVersionResponse;

class GetVersionHydrator
{
    public function hydrate(GetVersionResponse $getVersionResponse): array
    {
        return [
            'api_version' => $getVersionResponse->getApiVersion(),
        ];
    }
}
