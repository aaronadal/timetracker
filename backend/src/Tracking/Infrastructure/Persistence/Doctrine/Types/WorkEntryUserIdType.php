<?php

namespace Core\Tracking\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Infrastructure\Persistence\Doctrine\Types\UuidType;
use Core\Tracking\Domain\Entity\WorkEntryUserId;

final class WorkEntryUserIdType extends UuidType
{
    public static function name(): string
    {
        return 'tracking.work_entry.user';
    }

    protected function getValueObjectClass(): string
    {
        return WorkEntryUserId::class;
    }
}
