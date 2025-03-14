<?php

namespace Core\Tracking\Application\Command;

use Core\Auth\Application\Query\UserByIdQuery;
use Core\Shared\Domain\Bus\CommandHandlerInterface;
use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Core\Tracking\Domain\Exception\OpenWorkEntryAlreadyExists;
use Core\Tracking\Domain\Persistence\WorkEntryRepositoryInterface;

final class OpenWorkEntryHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly WorkEntryRepositoryInterface $repo,
        private readonly QueryBusInterface $queryBus,
    )
    {
    }

    public function __invoke(OpenWorkEntryCommand $command): void
    {
        $this->guardUserExists($command->user);
        $this->guardNoOpenWorkEntryExists($command->user);

        $entry = WorkEntry::create(
            id: $command->id,
            user: $command->user,
            start: $command->start,
        );

        $this->repo->save($entry);

        // TODO: Publish domain events.
    }

    private function guardUserExists(WorkEntryUserId $user): void
    {
        $this->queryBus->ask(new UserByIdQuery($user->value()));
    }

    private function guardNoOpenWorkEntryExists(WorkEntryUserId $user): void
    {
        $result = $this->repo->matching(['user' => $user->value(), 'close' => null, 'deletedAt' => null]);
        if(count($result) > 0) {
            throw OpenWorkEntryAlreadyExists::forUser($user);
        }
    }
}
