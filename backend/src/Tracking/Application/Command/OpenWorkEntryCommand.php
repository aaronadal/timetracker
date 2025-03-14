<?php

namespace Core\Tracking\Application\Command;

use Core\Shared\Domain\Bus\CommandInterface;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryStart;
use Core\Tracking\Domain\Entity\WorkEntryUserId;

final class OpenWorkEntryCommand implements CommandInterface
{
    public function __construct(
        public readonly WorkEntryId $id,
        public readonly WorkEntryUserId $user,
        public readonly WorkEntryStart $start,
    ) {
    }
}
