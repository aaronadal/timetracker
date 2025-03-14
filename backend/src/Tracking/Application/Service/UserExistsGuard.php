<?php

namespace Core\Tracking\Application\Service;

use Core\Auth\Application\Query\UserByIdQuery;
use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Tracking\Domain\Entity\WorkEntryUserId;

final class UserExistsGuard
{
    public function __construct(
        private readonly QueryBusInterface $bus,
    )
    {
    }

    public function __invoke(WorkEntryUserId $user): void
    {
        $this->bus->ask(new UserByIdQuery($user->value()));
    }
}
