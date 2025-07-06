<?php

declare(strict_types=1);

namespace App\Infrastructure\TelegramBot\DTO;

use Telegram\Bot\Commands\Command;

class TelegramBotDTO
{
    public function __construct(
        private string $telegramBotToken,
        /** @var array<Command> $commands */
        private array $commands,
    ) {
    }

    public function getTelegramBotToken(): string
    {
        return $this->telegramBotToken;
    }

    /** @return array<Command> $commands */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
