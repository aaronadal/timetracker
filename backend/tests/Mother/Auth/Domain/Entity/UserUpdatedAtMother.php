<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Shared\Domain\Entity\UpdatedAt;
use Test\Mother\TimestampMother;

final class UserUpdatedAtMother
{
    public static function random(): UpdatedAt
    {
        return UpdatedAt::fromValue(TimestampMother::lastYear());
    }
}
