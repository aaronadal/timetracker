<?php

namespace Test\Mother\Tracking\Domain\Entry;

use Core\Tracking\Domain\Entity\WorkEntryStart;
use Test\Mother\TimestampMother;

final class WorkEntryStartMother
{
    public static function random(): WorkEntryStart
    {
        return WorkEntryStart::fromValue(TimestampMother::lastYear());
    }
}
