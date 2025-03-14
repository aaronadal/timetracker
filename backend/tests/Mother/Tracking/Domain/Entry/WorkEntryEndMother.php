<?php

namespace Test\Mother\Tracking\Domain\Entry;

use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Test\Mother\TimestampMother;

final class WorkEntryEndMother
{
    public static function random(): WorkEntryEnd
    {
        return WorkEntryEnd::fromValue(TimestampMother::lastYear());
    }
}
