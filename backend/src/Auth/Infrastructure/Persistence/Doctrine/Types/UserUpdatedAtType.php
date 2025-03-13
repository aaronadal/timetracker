<?php

namespace Core\Auth\Infrastructure\Persistence\Doctrine\Types;

use Core\Auth\Domain\Entity\UserUpdatedAt;
use Core\Shared\Infrastructure\Persistence\Doctrine\Types\TimestampType;

final class UserUpdatedAtType extends TimestampType
{
    public static function name(): string
    {
        return 'auth.user.updated_at';
    }

    protected function getValueObjectClass(): string
    {
        return UserUpdatedAt::class;
    }
}