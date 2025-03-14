<?php

namespace Core\Tracking\Application\Command;

use Core\Shared\Domain\Bus\CommandInterface;
use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryStart;
use Core\Tracking\Domain\Entity\WorkEntryUserId;

final class UpdateWorkEntryCommand implements CommandInterface
{
    public function __construct(
        public readonly WorkEntryId     $id,
        public readonly WorkEntryUserId $user,
        public readonly WorkEntryStart  $start,
        public readonly ?WorkEntryEnd   $end,
    )
    {
    }
}
