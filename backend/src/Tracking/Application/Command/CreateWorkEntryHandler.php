<?php

namespace Core\Tracking\Application\Command;

use Core\Shared\Domain\Bus\CommandHandlerInterface;
use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Tracking\Application\Service\UserExistsGuard;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Core\Tracking\Domain\Persistence\WorkEntryRepositoryInterface;

final class CreateWorkEntryHandler implements CommandHandlerInterface
{
    private readonly UserExistsGuard $userExistsGuard;

    public function __construct(
        private readonly WorkEntryRepositoryInterface $repo,
        QueryBusInterface $queryBus,
    )
    {
        $this->userExistsGuard = new UserExistsGuard($queryBus);
    }

    public function __invoke(CreateWorkEntryCommand $command): void
    {
        $this->guardUserExists($command->user);

        $entry = WorkEntry::create(
            id: $command->id,
            user: $command->user,
            start: $command->start,
            end: $command->end,
        );

        $this->repo->save($entry);

        // TODO: Publish Domain Events.
    }

    private function guardUserExists(WorkEntryUserId $user): void
    {
        ($this->userExistsGuard)($user);
    }
}
