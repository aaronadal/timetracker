<?php

namespace Core\Shared\Domain\Persistence;

use Core\Shared\Domain\Entity\AggregateRoot;
use Core\Shared\Domain\Entity\UuidValueObject;

/** @template AR of AggregateRoot */
interface AggregateRootManagerInterface
{
    /** @param AR $aggregateRoot */
    public function save(AggregateRoot $aggregateRoot): void;

    public function exists(UuidValueObject $id): bool;

    /** @return AR|null */
    public function search(UuidValueObject $id): ?AggregateRoot;

    /**
     * @param non-empty-array<string, scalar> $criteria
     *
     * @return list<AR>
     */
    public function matching(array $criteria): array;
}
