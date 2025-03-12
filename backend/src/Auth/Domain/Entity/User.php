<?php

namespace Core\Auth\Domain\Entity;

use Core\Shared\Domain\Entity\AggregateRoot;

final class User extends AggregateRoot
{
    public static function create(UserId $id, UserName $name): User
    {
        return new self(
            id: $id,
            name: $name,
            createdAt: UserCreatedAt::now(),
            updatedAt: UserUpdatedAt::now(),
            deletedAt: null,
        );
    }

    public static function hydrate(
        UserId $id,
        UserName $name,
        UserCreatedAt $createdAt,
        UserUpdatedAt $updatedAt,
        ?UserDeletedAt $deletedAt,
    ): User {
        return new self(
            id: $id,
            name: $name,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            deletedAt: $deletedAt,
        );
    }

    private function __construct(
        private readonly UserId $id,
        private readonly UserName $name,
        private readonly UserCreatedAt $createdAt,
        private UserUpdatedAt $updatedAt,
        private ?UserDeletedAt $deletedAt,
    ) {
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function createdAt(): UserCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): UserUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?UserDeletedAt
    {
        return $this->deletedAt;
    }
}
