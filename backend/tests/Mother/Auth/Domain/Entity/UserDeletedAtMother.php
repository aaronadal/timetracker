<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Auth\Domain\Entity\UserDeletedAt;
use Test\Mother\TimestampMother;

final class UserDeletedAtMother
{
    public static function random(): UserDeletedAt
    {
        return UserDeletedAt::fromValue(TimestampMother::lastYear());
    }
}
