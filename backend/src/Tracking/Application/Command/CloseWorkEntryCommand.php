<?php

namespace Core\Tracking\Application\Command;

use Core\Shared\Domain\Bus\CommandInterface;
use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Core\Tracking\Domain\Entity\WorkEntryUserId;

final class CloseWorkEntryCommand implements CommandInterface
{
    public function __construct(
        public readonly WorkEntryUserId $user,
        public readonly WorkEntryEnd $end,
    ) {
    }
}
