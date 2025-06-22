<?php

declare(strict_types=1);

namespace App\Application\Http\API\Assembler\MailTelegram;

use App\Application\Http\API\DTO\MailTelegram\CreateMailTelegramRequestDTO;

class CreateMailTelegramRequestDTOAssembler
{
    public function assemble(array $requestContent): CreateMailTelegramRequestDTO
    {
        return new CreateMailTelegramRequestDTO(
            mailServerPath: $requestContent['mail_server_path'] ?? '',
            mail: $requestContent['mail'] ?? '',
            password: $requestContent['password'] ?? '',
            telegramChatId: (int) ($requestContent['telegram_chat_id'] ?? '')
        );
    }
}
