<?php

namespace Core\Auth\Infrastructure\Persistence\Doctrine;

use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Persistence\UserRepositoryInterface;
use Core\Shared\Domain\Persistence\AggregateRootManagerInterface;
use Core\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepositoryInterface;

final class DoctrineUserRepository implements UserRepositoryInterface, DoctrineRepositoryInterface
{
    /** @param AggregateRootManagerInterface<User> $manager */
    public function __construct(
        private readonly AggregateRootManagerInterface $manager,
    ) {
    }

    public function entityClass(): string
    {
        return User::class;
    }

    public function save(User $aggregateRoot): void
    {
        $this->manager->save($aggregateRoot);
    }

    public function exists(UserId $id): bool
    {
        return $this->manager->exists($id);
    }

    public function search(UserId $id): ?User
    {
        return $this->manager->search($id);
    }

    public function matching(array $criteria): array
    {
        return $this->manager->matching($criteria);
    }
}