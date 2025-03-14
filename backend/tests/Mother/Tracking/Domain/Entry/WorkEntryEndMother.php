<?php

namespace Test\Mother\Tracking\Domain\Entry;

use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Test\Mother\DifferentMother;
use Test\Mother\TimestampMother;

final class WorkEntryEndMother
{
    public static function random(): WorkEntryEnd
    {
        return WorkEntryEnd::fromValue(TimestampMother::lastYear());
    }

    public static function different(WorkEntryEnd|int $reference): WorkEntryEnd
    {
        if(is_int($reference)) {
            $reference = WorkEntryEnd::fromValue($reference);
        }

        return DifferentMother::create(
            $reference,
            static fn() => WorkEntryEndMother::random(),
        );
    }
}
