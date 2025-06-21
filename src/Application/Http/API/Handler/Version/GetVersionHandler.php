<?php

declare(strict_types=1);

namespace App\Application\Http\API\Handler\Version;

use App\Application\Http\API\Response\Version\GetVersionResponse;

class GetVersionHandler
{
    public function __construct(private string $apiVersion)
    {
    }

    public function handle(): GetVersionResponse
    {
        return new GetVersionResponse($this->apiVersion);
    }
}
