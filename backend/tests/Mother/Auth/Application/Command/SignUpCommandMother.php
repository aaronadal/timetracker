<?php

namespace Test\Mother\Auth\Application\Command;

use Core\Auth\Application\Command\SignUpCommand;
use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Entity\UserName;
use Test\Mother\Auth\Domain\Entity\UserIdMother;
use Test\Mother\Auth\Domain\Entity\UserNameMother;

final class SignUpCommandMother
{
    public static function create(
        ?UserId $id = null,
        ?UserName $name = null,
    ): SignUpCommand {
        return new SignUpCommand(
            id: $id ?? UserIdMother::random(),
            name: $name ?? UserNameMother::random(),
        );
    }
}
