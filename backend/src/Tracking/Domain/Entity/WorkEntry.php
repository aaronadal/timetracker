<?php

namespace Core\Tracking\Domain\Entity;

use Core\Shared\Domain\Entity\AggregateRoot;
use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\DeletedAt;
use Core\Shared\Domain\Entity\UpdatedAt;

final class WorkEntry extends AggregateRoot
{
    public static function create(
        WorkEntryId     $id,
        WorkEntryUserId $user,
        WorkEntryStart  $start,
    ): self
    {
        return new self(
            id: $id,
            user: $user,
            start: $start,
            end: null,
            createdAt: CreatedAt::now(),
            updatedAt: UpdatedAt::now(),
            deletedAt: null,
        );
    }

    public static function hydrate(
        WorkEntryId     $id,
        WorkEntryUserId $user,
        WorkEntryStart  $start,
        ?WorkEntryEnd   $end,
        CreatedAt       $createdAt,
        UpdatedAt       $updatedAt,
        ?DeletedAt      $deletedAt,
    ): self
    {
        return new self(
            id: $id,
            user: $user,
            start: $start,
            end: $end,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            deletedAt: $deletedAt,
        );
    }

    private function __construct(
        private readonly WorkEntryId     $id,
        private readonly WorkEntryUserId $user,
        private readonly WorkEntryStart  $start,
        private ?WorkEntryEnd            $end,
        private readonly CreatedAt       $createdAt,
        private UpdatedAt                $updatedAt,
        private ?DeletedAt               $deletedAt,
    )
    {
    }

    public function id(): WorkEntryId
    {
        return $this->id;
    }

    public function user(): WorkEntryUserId
    {
        return $this->user;
    }

    public function start(): WorkEntryStart
    {
        return $this->start;
    }

    public function end(): ?WorkEntryEnd
    {
        return $this->end;
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
