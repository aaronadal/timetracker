<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Auth\Domain\Entity\UserName;
use Test\Mother\StringMother;

final class UserNameMother
{
    public static function random(): UserName
    {
        return UserName::fromValue(StringMother::name());
    }
}
