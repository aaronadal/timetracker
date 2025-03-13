<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Auth\Domain\Entity\UserId;

final class UserIdMother
{
    public static function random(): UserId
    {
        return UserId::random();
    }
}
