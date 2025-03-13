<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Auth\Domain\Entity\UserCreatedAt;
use Test\Mother\TimestampMother;

final class UserCreatedAtMother
{
    public static function random(): UserCreatedAt
    {
        return UserCreatedAt::fromValue(TimestampMother::lastYear());
    }
}
