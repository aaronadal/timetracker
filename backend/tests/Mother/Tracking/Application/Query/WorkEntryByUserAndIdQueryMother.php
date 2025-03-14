<?php

namespace Test\Mother\Tracking\Application\Query;

use Core\Tracking\Application\Query\WorkEntryByUserAndIdQuery;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Test\Mother\Tracking\Domain\Entry\WorkEntryUserIdMother;

final class WorkEntryByUserAndIdQueryMother
{
    public static function create(
        ?string $id = null,
        ?string $user = null,
    ): WorkEntryByUserAndIdQuery {
        return new WorkEntryByUserAndIdQuery(
            id: $id ?? WorkEntryId::random()->value(),
            user: $user ?? WorkEntryUserIdMother::random()->value(),
        );
    }
}
