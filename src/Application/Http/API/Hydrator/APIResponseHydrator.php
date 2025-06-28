<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator;

use App\Application\Http\API\DTO\Error\ErrorListResponseDTO;
use App\Application\Http\API\Hydrator\Error\ErrorListHydrator;

class APIResponseHydrator
{
    public function __construct(private ErrorListHydrator $errorListHydrator)
    {
    }

    public function extract(
        array $responseData,
        bool $success,
        ?ErrorListResponseDTO $errorListResponseDTO
    ): array {
        return [
            'success' => $success,
            'errors' => $errorListResponseDTO instanceof ErrorListResponseDTO
                ? $this->errorListHydrator->extract($errorListResponseDTO)
                : [],
            'data' => $responseData,
        ];
    }
}
