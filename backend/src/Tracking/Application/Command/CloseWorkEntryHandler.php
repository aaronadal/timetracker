<?php

namespace Core\Tracking\Application\Command;

use Core\Shared\Domain\Bus\CommandHandlerInterface;
use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Tracking\Application\Service\UserExistsGuard;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Core\Tracking\Domain\Exception\OpenWorkEntryNotFound;
use Core\Tracking\Domain\Persistence\WorkEntryRepositoryInterface;

final class CloseWorkEntryHandler implements CommandHandlerInterface
{
    private readonly UserExistsGuard $userExistsGuard;

    public function __construct(
        private readonly WorkEntryRepositoryInterface $repo,
        QueryBusInterface $queryBus,
    )
    {
        $this->userExistsGuard = new UserExistsGuard($queryBus);
    }

    public function __invoke(CloseWorkEntryCommand $command): void
    {
        $this->guardUserExists($command->user);
        $entry = $this->guardOpenWorkEntryExists($command->user);

        $entry->updateEnd($command->end);
        $entry->updated();

        $this->repo->save($entry);

        // TODO: Publish Domain Events.
    }

    private function guardUserExists(WorkEntryUserId $user): void
    {
        ($this->userExistsGuard)($user);
    }

    private function guardOpenWorkEntryExists(WorkEntryUserId $user): WorkEntry
    {
        $result = $this->repo->matching(['user' => $user->value(), 'close' => null, 'deletedAt' => null]);
        if(count($result) === 0) {
            throw OpenWorkEntryNotFound::forUser($user);
        }

        return $result[0];
    }
}
