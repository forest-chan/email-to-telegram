<?php

declare(strict_types=1);

namespace App\Domain\Repository\MailTelegramUser;

use App\Domain\Entity\MailTelegramUser\MailTelegramUser;

interface MailTelegramUserRepositoryInterface
{
    /** @return array<MailTelegramUser> */
    public function findAllWithUser(): array;
}
