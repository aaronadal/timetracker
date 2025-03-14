<?php

namespace Core\Tracking\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Infrastructure\Persistence\Doctrine\Types\TimestampType;
use Core\Tracking\Domain\Entity\WorkEntryEnd;

final class WorkEntryEndType extends TimestampType
{
    public static function name(): string
    {
        return 'tracking.work_entry.end';
    }

    protected function getValueObjectClass(): string
    {
        return WorkEntryEnd::class;
    }
}
