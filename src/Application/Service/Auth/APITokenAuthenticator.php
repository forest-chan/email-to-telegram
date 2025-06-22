<?php

declare(strict_types=1);

namespace App\Application\Service\Auth;

class APITokenAuthenticator implements TokenAuthenticatorInterface
{
    public function __construct(private string $APIToken)
    {
    }

    public function authenticate(string $token): bool
    {
        return $token === $this->APIToken;
    }
}
