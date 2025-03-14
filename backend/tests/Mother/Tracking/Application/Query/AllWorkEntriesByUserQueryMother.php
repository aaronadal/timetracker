<?php

namespace Test\Mother\Tracking\Application\Query;

use Core\Tracking\Application\Query\AllWorkEntriesByUserQuery;
use Test\Mother\Tracking\Domain\Entry\WorkEntryUserIdMother;

final class AllWorkEntriesByUserQueryMother
{
    public static function create(
        ?string $user = null,
    ): AllWorkEntriesByUserQuery {
        return new AllWorkEntriesByUserQuery(
            user: $user ?? WorkEntryUserIdMother::random()->value(),
        );
    }
}
