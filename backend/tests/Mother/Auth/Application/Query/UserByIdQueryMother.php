<?php

namespace Test\Mother\Auth\Application\Query;

use Core\Auth\Application\Query\UserByIdQuery;
use Test\Mother\Auth\Domain\Entity\UserIdMother;

final class UserByIdQueryMother
{
    public static function create(
        ?string $id = null,
    ): UserByIdQuery {
        return new UserByIdQuery(
            id: $id ?? UserIdMother::random()->value(),
        );
    }
}
