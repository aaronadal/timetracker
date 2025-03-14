<?php

namespace Test\Mother\Tracking\Application\Command;

use Core\Tracking\Application\Command\DeleteWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Test\Mother\Tracking\Domain\Entry\WorkEntryIdMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryUserIdMother;

final class DeleteWorkEntryCommandMother
{
    public static function create(
        ?WorkEntryId $id = null,
        ?WorkEntryUserId $user = null,
    ): DeleteWorkEntryCommand {
        return new DeleteWorkEntryCommand(
            id: $id ?? WorkEntryIdMother::random(),
            user: $user ?? WorkEntryUserIdMother::random(),
        );
    }
}
