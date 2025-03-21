<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Entity\UserName;
use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\DeletedAt;
use Core\Shared\Domain\Entity\UpdatedAt;
use Test\Mother\Nullable;
use Test\Mother\Shared\Domain\Entity\CreatedAtMother;
use Test\Mother\Shared\Domain\Entity\DeletedAtMother;
use Test\Mother\Shared\Domain\Entity\UpdatedAtMother;

final class UserMother
{
    /** @param DeletedAt|Nullable<DeletedAt>|Nullable<null>|null $deletedAt */
    public static function create(
        ?UserId                 $id = null,
        ?UserName               $name = null,
        ?CreatedAt              $createdAt = null,
        ?UpdatedAt              $updatedAt = null,
        DeletedAt|Nullable|null $deletedAt = null,
    ): User {
        return User::hydrate(
            id: $id ?? UserIdMother::random(),
            name: $name ?? UserNameMother::random(),
            createdAt: $createdAt ?? CreatedAtMother::random(),
            updatedAt: $updatedAt ?? UpdatedAtMother::random(),
            deletedAt: Nullable::resolve(
                $deletedAt,
                static fn() => DeletedAtMother::random(),
            ),
        );
    }

    public static function createNotDeleted(
        ?UserId    $id = null,
        ?UserName  $name = null,
        ?CreatedAt $createdAt = null,
        ?UpdatedAt $updatedAt = null,
    ): User {
        return self::create($id, $name, $createdAt, $updatedAt, Nullable::null());
    }
}
