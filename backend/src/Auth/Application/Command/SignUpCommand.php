<?php

namespace Core\Auth\Application\Command;

use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Entity\UserName;
use Core\Shared\Domain\Bus\CommandInterface;

final class SignUpCommand implements CommandInterface
{
    public function __construct(
        public readonly UserId $id,
        public readonly UserName $name,
    ) {
    }
}
