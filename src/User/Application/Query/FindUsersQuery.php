<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final readonly class FindUsersQuery implements QueryInterface
{
    // Scope here to add in more ways to search for collection of users, like by group or location?
    public function __construct(
        public ?int $page = null,
        public ?int $itemsPerPage = null,
    ) {
    }
}
