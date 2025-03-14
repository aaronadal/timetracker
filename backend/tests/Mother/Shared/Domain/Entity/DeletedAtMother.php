<?php

namespace Test\Mother\Shared\Domain\Entity;

use Core\Shared\Domain\Entity\DeletedAt;
use Test\Mother\TimestampMother;

final class DeletedAtMother
{
    public static function random(): DeletedAt
    {
        return DeletedAt::fromValue(TimestampMother::lastYear());
    }
}
