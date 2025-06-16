<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\DTO;

use App\Infrastructure\Imap\Enum\SearchCriteria;
use App\Infrastructure\Imap\Enum\SortCriteria;

class GetMailIdsRequestDTO extends RequestDTO
{
    public function __construct(
        private SearchCriteria $searchCriteria,
        private SortCriteria $sortCriteria,
    ) {
    }

    public function getSearchCriteria(): SearchCriteria
    {
        return $this->searchCriteria;
    }

    public function getSortCriteria(): SortCriteria
    {
        return $this->sortCriteria;
    }

    public function toArray(): array
    {
        return [
            'search_criteria' => $this->searchCriteria->name,
            'sort_criteria' => $this->sortCriteria->name
        ];
    }
}
