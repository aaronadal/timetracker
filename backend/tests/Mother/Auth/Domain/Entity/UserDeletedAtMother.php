<?php

namespace Test\Mother\Auth\Domain\Entity;

use Core\Shared\Domain\Entity\DeletedAt;
use Test\Mother\TimestampMother;

final class UserDeletedAtMother
{
    public static function random(): DeletedAt
    {
        return DeletedAt::fromValue(TimestampMother::lastYear());
    }
}
