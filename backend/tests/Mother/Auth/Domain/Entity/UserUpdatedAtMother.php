<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Auth\Domain\Entity\UserUpdatedAt;
use Test\Mother\TimestampMother;

final class UserUpdatedAtMother
{
    public static function random(): UserUpdatedAt
    {
        return UserUpdatedAt::fromValue(TimestampMother::lastYear());
    }
}
