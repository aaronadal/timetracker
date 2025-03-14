<?php

namespace Test\Mother\Shared\Domain\Entity;

use Core\Shared\Domain\Entity\CreatedAt;
use Test\Mother\TimestampMother;

final class CreatedAtMother
{
    public static function random(): CreatedAt
    {
        return CreatedAt::fromValue(TimestampMother::lastYear());
    }
}
