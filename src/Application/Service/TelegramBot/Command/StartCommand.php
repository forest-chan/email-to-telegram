<?php

declare(strict_types=1);

namespace App\Application\Service\TelegramBot\Command;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = "start";

    public function handle(): void
    {
        $this->replyWithMessage(['text' => 'Добро пожаловать!']);
    }
}
