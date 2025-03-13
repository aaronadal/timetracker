<?php

namespace Core\Auth\Infrastructure\Persistence\Doctrine\Types;

use Core\Auth\Domain\Entity\UserName;
use Core\Shared\Infrastructure\Persistence\Doctrine\Types\StringType;

final class UserNameType extends StringType
{
    public static function name(): string
    {
        return 'auth.user.name';
    }

    protected function getValueObjectClass(): string
    {
        return UserName::class;
    }
}