<?php

namespace Core\Auth\Infrastructure\Persistence\Doctrine\Types;

use Core\Auth\Domain\Entity\UserDeletedAt;
use Core\Shared\Infrastructure\Persistence\Doctrine\Types\TimestampType;

final class UserDeletedAtType extends TimestampType
{
    public static function name(): string
    {
        return 'auth.user.deleted_at';
    }

    protected function getValueObjectClass(): string
    {
        return UserDeletedAt::class;
    }
}