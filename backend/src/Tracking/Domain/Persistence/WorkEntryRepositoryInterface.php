<?php

namespace Core\Tracking\Domain\Persistence;

use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryId;

interface WorkEntryRepositoryInterface
{
    public function save(WorkEntry $aggregateRoot): void;

    public function exists(WorkEntryId $id): bool;

    public function search(WorkEntryId $id): ?WorkEntry;

    /**
     * @param non-empty-array<string, scalar|null> $criteria
     *
     * @return list<WorkEntry>
     */
    public function matching(array $criteria): array;
}
