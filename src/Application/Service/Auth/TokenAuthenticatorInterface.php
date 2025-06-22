<?php

declare(strict_types=1);

namespace App\Application\Service\Auth;

interface TokenAuthenticatorInterface
{
    public function authenticate(string $token): bool;
}
