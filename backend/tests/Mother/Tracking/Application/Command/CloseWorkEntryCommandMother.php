<?php

namespace Test\Mother\Tracking\Application\Command;

use Core\Tracking\Application\Command\CloseWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Test\Mother\Tracking\Domain\Entry\WorkEntryEndMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryUserIdMother;

final class CloseWorkEntryCommandMother
{
    public static function create(
        ?WorkEntryUserId $user = null,
        ?WorkEntryEnd $start = null,
    ): CloseWorkEntryCommand {
        return new CloseWorkEntryCommand(
            user: $user ?? WorkEntryUserIdMother::random(),
            end: $start ?? WorkEntryEndMother::random(),
        );
    }
}
