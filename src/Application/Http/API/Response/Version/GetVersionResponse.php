<?php

declare(strict_types=1);

namespace App\Application\Http\API\Response\Version;

class GetVersionResponse
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
