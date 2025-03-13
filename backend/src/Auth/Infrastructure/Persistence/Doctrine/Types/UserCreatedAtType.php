<?php

namespace Core\Auth\Infrastructure\Persistence\Doctrine\Types;

use Core\Auth\Domain\Entity\UserCreatedAt;
use Core\Shared\Infrastructure\Persistence\Doctrine\Types\TimestampType;

final class UserCreatedAtType extends TimestampType
{
    public static function name(): string
    {
        return 'auth.user.created_at';
    }

    protected function getValueObjectClass(): string
    {
        return UserCreatedAt::class;
    }
}