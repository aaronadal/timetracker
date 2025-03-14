<?php

namespace Test\Mother\Tracking\Domain\Entry;

use Core\Tracking\Domain\Entity\WorkEntryId;

final class WorkEntryIdMother
{
    public static function random(): WorkEntryId
    {
        return WorkEntryId::random();
    }
}
