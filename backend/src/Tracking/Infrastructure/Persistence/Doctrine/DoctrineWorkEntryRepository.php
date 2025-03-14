<?php

namespace Core\Tracking\Infrastructure\Persistence\Doctrine;

use Core\Shared\Domain\Persistence\AggregateRootManagerInterface;
use Core\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepositoryInterface;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Persistence\WorkEntryRepositoryInterface;

final class DoctrineWorkEntryRepository implements WorkEntryRepositoryInterface, DoctrineRepositoryInterface
{
    /** @param AggregateRootManagerInterface<WorkEntry> $manager */
    public function __construct(
        private readonly AggregateRootManagerInterface $manager,
    ) {
    }

    public function entityClass(): string
    {
        return WorkEntry::class;
    }

    public function save(WorkEntry $aggregateRoot): void
    {
        $this->manager->save($aggregateRoot);
    }

    public function exists(WorkEntryId $id): bool
    {
        return $this->manager->exists($id);
    }

    public function search(WorkEntryId $id): ?WorkEntry
    {
        return $this->manager->search($id);
    }

    public function matching(array $criteria): array
    {
        return $this->manager->matching($criteria);
    }
}
