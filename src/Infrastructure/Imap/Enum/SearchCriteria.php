<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Enum;

enum SearchCriteria: string
{
    case UNSEEN = 'UNSEEN';
}
