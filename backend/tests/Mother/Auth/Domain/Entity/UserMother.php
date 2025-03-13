<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserCreatedAt;
use Core\Auth\Domain\Entity\UserDeletedAt;
use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Entity\UserName;
use Core\Auth\Domain\Entity\UserUpdatedAt;
use Test\Mother\Nullable;

final class UserMother
{
    /** @param UserDeletedAt|Nullable<UserDeletedAt>|Nullable<null>|null $deletedAt */
    public static function create(
        ?UserId $id = null,
        ?UserName $name = null,
        ?UserCreatedAt $createdAt = null,
        ?UserUpdatedAt $updatedAt = null,
        UserDeletedAt|Nullable|null $deletedAt = null,
    ): User {
        return User::hydrate(
            id: $id ?? UserIdMother::random(),
            name: $name ?? UserNameMother::random(),
            createdAt: $createdAt ?? UserCreatedAtMother::random(),
            updatedAt: $updatedAt ?? UserUpdatedAtMother::random(),
            deletedAt: Nullable::resolve(
                $deletedAt,
                static fn() => UserDeletedAtMother::random(),
            ),
        );
    }

    public static function createNotDeleted(
        ?UserId $id = null,
        ?UserName $name = null,
        ?UserCreatedAt $createdAt = null,
        ?UserUpdatedAt $updatedAt = null,
    ): User {
        return self::create($id, $name, $createdAt, $updatedAt, Nullable::null());
    }
}
