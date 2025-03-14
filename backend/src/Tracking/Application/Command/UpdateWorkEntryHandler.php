<?php

namespace Core\Tracking\Application\Command;

use Core\Shared\Domain\Bus\CommandHandlerInterface;
use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Shared\Domain\Exception\EntityNotFound;
use Core\Tracking\Application\Service\UserExistsGuard;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Core\Tracking\Domain\Persistence\WorkEntryRepositoryInterface;

final class UpdateWorkEntryHandler implements CommandHandlerInterface
{
    private readonly UserExistsGuard $userExistsGuard;

    public function __construct(
        private readonly WorkEntryRepositoryInterface $repo,
        QueryBusInterface $queryBus,
    )
    {
        $this->userExistsGuard = new UserExistsGuard($queryBus);
    }

    public function __invoke(UpdateWorkEntryCommand $command): void
    {
        $this->guardUserExists($command->user);
        $entry = $this->guardWorkEntryExists($command->id, $command->user);

        $entry->updateInterval($command->start, $command->end);
        $entry->updated();

        $this->repo->save($entry);

        // TODO: Publish Domain Events.
    }

    private function guardUserExists(WorkEntryUserId $user): void
    {
        ($this->userExistsGuard)($user);
    }

    private function guardWorkEntryExists(WorkEntryId $id, WorkEntryUserId $user): WorkEntry
    {
        $result = $this->repo->matching(['id' => $id->value(), 'user' => $user->value(), 'deletedAt' => null]);
        if(count($result) === 0) {
            throw EntityNotFound::forClassAndId(WorkEntry::class, $id);
        }

        return $result[0];
    }
}
