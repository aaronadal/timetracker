<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Shared\Domain\Entity\CreatedAt;
use Test\Mother\TimestampMother;

final class UserCreatedAtMother
{
    public static function random(): CreatedAt
    {
        return CreatedAt::fromValue(TimestampMother::lastYear());
    }
}
