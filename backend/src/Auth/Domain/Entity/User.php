<?php

namespace Core\Auth\Domain\Entity;

use Core\Shared\Domain\Entity\AggregateRoot;
use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\DeletedAt;
use Core\Shared\Domain\Entity\UpdatedAt;

final class User extends AggregateRoot
{
    public static function create(UserId $id, UserName $name): User
    {
        return new self(
            id: $id,
            name: $name,
            createdAt: CreatedAt::now(),
            updatedAt: UpdatedAt::now(),
            deletedAt: null,
        );
    }

    public static function hydrate(
        UserId     $id,
        UserName   $name,
        CreatedAt  $createdAt,
        UpdatedAt  $updatedAt,
        ?DeletedAt $deletedAt,
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
        private readonly UserId    $id,
        private readonly UserName  $name,
        private readonly CreatedAt $createdAt,
        private UpdatedAt          $updatedAt,
        private ?DeletedAt         $deletedAt,
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

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?DeletedAt
    {
        return $this->deletedAt;
    }
}
