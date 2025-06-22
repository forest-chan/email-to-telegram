<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator;

class APIResponseHydrator
{
    public function extract(array $responseData): array
    {
        return [
            'data' => $responseData,
        ];
    }
}
