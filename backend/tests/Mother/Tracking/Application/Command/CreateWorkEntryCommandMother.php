<?php

namespace Test\Mother\Tracking\Application\Command;

use Core\Tracking\Application\Command\CreateWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryStart;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Test\Mother\Nullable;
use Test\Mother\Tracking\Domain\Entry\WorkEntryEndMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryIdMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryStartMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryUserIdMother;

final class CreateWorkEntryCommandMother
{
    /** @param WorkEntryEnd|Nullable<WorkEntryEnd>|Nullable<null>|null $end */
    public static function create(
        ?WorkEntryId $id = null,
        ?WorkEntryUserId $user = null,
        ?WorkEntryStart $start = null,
        WorkEntryEnd|Nullable|null $end = null,
    ): CreateWorkEntryCommand {
        return new CreateWorkEntryCommand(
            id: $id ?? WorkEntryIdMother::random(),
            user: $user ?? WorkEntryUserIdMother::random(),
            start: $start ?? WorkEntryStartMother::random(),
            end: Nullable::resolve(
                $end,
                static fn() => WorkEntryEndMother::random(),
            ),
        );
    }
}
