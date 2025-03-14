<?php

namespace Test\Mother\Tracking\Domain\Entry;

use Core\Tracking\Domain\Entity\WorkEntryUserId;

final class WorkEntryUserIdMother
{
    public static function random(): WorkEntryUserId
    {
        return WorkEntryUserId::random();
    }
}
