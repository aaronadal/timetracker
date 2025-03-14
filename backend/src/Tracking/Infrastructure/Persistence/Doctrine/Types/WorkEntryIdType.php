<?php

namespace Core\Tracking\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Infrastructure\Persistence\Doctrine\Types\UuidType;
use Core\Tracking\Domain\Entity\WorkEntryId;

final class WorkEntryIdType extends UuidType
{
    public static function name(): string
    {
        return 'tracking.work_entry.id';
    }

    protected function getValueObjectClass(): string
    {
        return WorkEntryId::class;
    }
}
