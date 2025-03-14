<?php

namespace Core\Tracking\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Infrastructure\Persistence\Doctrine\Types\TimestampType;
use Core\Tracking\Domain\Entity\WorkEntryStart;

final class WorkEntryStartType extends TimestampType
{
    public static function name(): string
    {
        return 'tracking.work_entry.start';
    }

    protected function getValueObjectClass(): string
    {
        return WorkEntryStart::class;
    }
}
