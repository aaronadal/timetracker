<?php

namespace Test\Mother\Tracking\Application\Command;

use Core\Tracking\Application\Command\OpenWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryStart;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Test\Mother\Tracking\Domain\Entry\WorkEntryIdMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryStartMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryUserIdMother;

final class OpenWorkEntryCommandMother
{
    public static function create(
        ?WorkEntryId $id = null,
        ?WorkEntryUserId $user = null,
        ?WorkEntryStart $start = null,
    ): OpenWorkEntryCommand {
        return new OpenWorkEntryCommand(
            id: $id ?? WorkEntryIdMother::random(),
            user: $user ?? WorkEntryUserIdMother::random(),
            start: $start ?? WorkEntryStartMother::random(),
        );
    }
}
