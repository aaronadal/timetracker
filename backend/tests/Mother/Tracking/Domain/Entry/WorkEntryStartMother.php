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

    public static function before(WorkEntryStart|int $reference): WorkEntryStart
    {
        if($reference instanceof WorkEntryStart) {
            $reference = $reference->value();
        }

        return WorkEntryStart::fromValue(TimestampMother::pastBefore($reference));
    }

    public static function after(WorkEntryStart|int $reference): WorkEntryStart
    {
        if($reference instanceof WorkEntryStart) {
            $reference = $reference->value();
        }

        return WorkEntryStart::fromValue(TimestampMother::pastAfter($reference));
    }
}
