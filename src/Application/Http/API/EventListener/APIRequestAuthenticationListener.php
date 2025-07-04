<?php

declare(strict_types=1);

namespace App\Application\Http\API\EventListener;

use App\Application\Http\API\Assembler\Error\ErrorListAssembler;
use App\Application\Http\API\Hydrator\APIResponseHydrator;
use App\Application\Service\Auth\TokenAuthenticatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class APIRequestAuthenticationListener
{
    private const API_ROUTE_PREFIX = '/api';
    private const X_API_TOKEN_HEADER = 'X-API-Token';
    private const NOT_AUTHENTICATED_ERROR_MESSAGE = 'Not authenticated';

    public function __construct(
        private ErrorListAssembler $errorListAssembler,
        private APIResponseHydrator $apiResponseHydrator,
        private TokenAuthenticatorInterface $tokenAuthenticator,
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isAPIRequest($request)) {
            return;
        }

        if ($this->isRequestAuthenticated($request)) {
            return;
        }

        $event->setResponse(
            response: new JsonResponse(
                data: $this->apiResponseHydrator->extract(
                    responseData: [],
                    success: false,
                    errorListResponseDTO: $this->errorListAssembler->assembleFromErrorMessages([self::NOT_AUTHENTICATED_ERROR_MESSAGE])
                ),
                status: Response::HTTP_UNAUTHORIZED
            )
        );
    }

    private function isAPIRequest(Request $request): bool
    {
        return str_starts_with($request->getPathInfo(), self::API_ROUTE_PREFIX);
    }

    private function isRequestAuthenticated(Request $request): bool
    {
        $APIToken = $request->headers->get(self::X_API_TOKEN_HEADER);

        if ($APIToken === null) {
            return false;
        }

        return $this->tokenAuthenticator->authenticate($APIToken);
    }
}
