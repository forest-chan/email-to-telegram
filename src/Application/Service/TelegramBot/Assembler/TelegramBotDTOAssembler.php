<?php

declare(strict_types=1);

namespace App\Application\Service\TelegramBot\Assembler;

use App\Infrastructure\TelegramBot\DTO\TelegramBotDTO;

class TelegramBotDTOAssembler
{
    public function assembleFromConfig(array $config): TelegramBotDTO
    {
        return new TelegramBotDTO(
            telegramBotToken: $config['telegram_bot_token'],
            commands: $config['commands'],
        );
    }
}
