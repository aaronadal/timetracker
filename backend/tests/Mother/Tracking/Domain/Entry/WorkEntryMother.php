<?php

namespace Test\Mother\Tracking\Domain\Entry;

use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\DeletedAt;
use Core\Shared\Domain\Entity\UpdatedAt;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryStart;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Test\Mother\Nullable;
use Test\Mother\Shared\Domain\Entity\CreatedAtMother;
use Test\Mother\Shared\Domain\Entity\DeletedAtMother;
use Test\Mother\Shared\Domain\Entity\UpdatedAtMother;

final class WorkEntryMother
{
    /**
     * @param WorkEntryEnd|Nullable<WorkEntryEnd>|Nullable<null>|null $end
     * @param DeletedAt|Nullable<DeletedAt>|Nullable<null>|null $deletedAt
     */
    public static function create(
        ?WorkEntryId $id = null,
        ?WorkEntryUserId $user = null,
        ?WorkEntryStart $start = null,
        WorkEntryEnd|Nullable|null $end = null,
        ?CreatedAt $createdAt = null,
        ?UpdatedAt $updatedAt = null,
        DeletedAt|Nullable|null $deletedAt = null,
    ): WorkEntry
    {
        return WorkEntry::hydrate(
            id: $id ?? WorkEntryIdMother::random(),
            user: $user ?? WorkEntryUserIdMother::random(),
            start: $start ?? WorkEntryStartMother::random(),
            end: Nullable::resolve(
                $end,
                static fn() => WorkEntryEndMother::random(),
            ),
            createdAt: $createdAt ?? CreatedAtMother::random(),
            updatedAt: $updatedAt ?? UpdatedAtMother::random(),
            deletedAt: Nullable::resolve(
                $deletedAt,
                static fn() => DeletedAtMother::random(),
            ),
        );
    }

    public static function createOpen(
        ?WorkEntryId $id = null,
        ?WorkEntryUserId $user = null,
        ?WorkEntryStart $start = null,
        ?CreatedAt $createdAt = null,
        ?UpdatedAt $updatedAt = null,
    ): WorkEntry
    {
        return self::create(
            id: $id,
            user: $user,
            start: $start,
            end: Nullable::null(),
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            deletedAt: Nullable::null(),
        );
    }
}
