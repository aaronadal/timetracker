<?php

namespace Test\Mother\Shared\Domain\Entity;

use Core\Shared\Domain\Entity\UpdatedAt;
use Test\Mother\TimestampMother;

final class UpdatedAtMother
{
    public static function random(): UpdatedAt
    {
        return UpdatedAt::fromValue(TimestampMother::lastYear());
    }
}
