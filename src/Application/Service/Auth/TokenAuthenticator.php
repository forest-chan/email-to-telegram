<?php

declare(strict_types=1);

namespace App\Application\Service\Auth;

class TokenAuthenticator implements TokenAuthenticatorInterface
{
    public function __construct(private string $token)
    {
    }

    public function authenticate(string $token): bool
    {
        return $token === $this->token;
    }
}
