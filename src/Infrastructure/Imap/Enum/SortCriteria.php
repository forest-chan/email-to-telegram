<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Enum;

enum SortCriteria: int
{
    case ARRIVAL_DATE = 1;
}
