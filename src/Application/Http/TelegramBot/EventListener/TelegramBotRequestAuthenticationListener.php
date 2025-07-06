<?php

declare(strict_types=1);

namespace App\Application\Http\TelegramBot\EventListener;

use App\Application\Service\Auth\TokenAuthenticatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TelegramBotRequestAuthenticationListener
{
    private const TELEGRAM_BOT_ROUTE_PREFIX = '/telegram-bot';
    private const X_TELEGRAM_BOT_API_SECRET_TOKEN = 'X-Telegram-Bot-Api-Secret-Token';

    public function __construct(
        private TokenAuthenticatorInterface $tokenAuthenticator,
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isTelegramBotRequest($request)) {
            return;
        }

        if ($this->isRequestAuthenticated($request)) {
            return;
        }

        $event->setResponse(new JsonResponse(null, Response::HTTP_UNAUTHORIZED));
    }

    private function isTelegramBotRequest(Request $request): bool
    {
        return str_starts_with($request->getPathInfo(), self::TELEGRAM_BOT_ROUTE_PREFIX);
    }

    private function isRequestAuthenticated(Request $request): bool
    {
        $telegramBotSecretAPIToken = $request->headers->get(self::X_TELEGRAM_BOT_API_SECRET_TOKEN);

        if ($telegramBotSecretAPIToken === null) {
            return false;
        }

        return $this->tokenAuthenticator->authenticate($telegramBotSecretAPIToken);
    }
}
