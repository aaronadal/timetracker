<?php

namespace Core\Auth\Infrastructure\Persistence\Doctrine\Types;

use Core\Auth\Domain\Entity\UserId;
use Core\Shared\Infrastructure\Persistence\Doctrine\Types\UuidType;

final class UserIdType extends UuidType
{
    public static function name(): string
    {
        return 'auth.user.id';
    }

    protected function getValueObjectClass(): string
    {
        return UserId::class;
    }
}