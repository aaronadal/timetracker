<?php

namespace Core\Auth\Domain\Persistence;

use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;

interface UserRepositoryInterface
{
    public function save(User $aggregateRoot): void;

    public function exists(UserId $id): bool;

    public function search(UserId $id): ?User;

    /**
     * @param non-empty-array<string, scalar> $criteria
     *
     * @return list<User>
     */
    public function matching(array $criteria): array;
}
