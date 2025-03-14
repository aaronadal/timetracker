<?php

namespace Core\Tracking\Domain\Entity;

use Core\Shared\Domain\Entity\AggregateRoot;
use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\DeletedAt;
use Core\Shared\Domain\Entity\UpdatedAt;
use Core\Shared\Domain\Exception\InvalidInterval;

final class WorkEntry extends AggregateRoot
{
    public static function open(
        WorkEntryId     $id,
        WorkEntryUserId $user,
        WorkEntryStart  $start,
    ): self
    {
        return self::create(
            $id,
            $user,
            $start,
            null,
        );
    }

    public static function create(
        WorkEntryId     $id,
        WorkEntryUserId $user,
        WorkEntryStart  $start,
        ?WorkEntryEnd   $end,
    ): self
    {
        $instance = new self(
            id: $id,
            user: $user,
            start: $start,
            end: $end,
            createdAt: CreatedAt::now(),
            updatedAt: UpdatedAt::now(),
            deletedAt: null,
        );

        $instance->guardEndIsAfterStart();

        // TODO: Record WorkEntryCreated Domain Event.

        return $instance;
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

    public function updateEnd(?WorkEntryEnd $end): void
    {
        if(WorkEntryEnd::nullableEquals($this->end(), $end)) {
            return;
        }

        $this->end = $end;
        $this->guardEndIsAfterStart();

        // TODO: Record WorkEntryCreated Domain Event.
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

    public function updated(): void
    {
        $this->updatedAt = UpdatedAt::now();

        // TODO: Record WorkEntryUpdated Domain Event.
    }

    public function deleted(): void
    {
        $this->deletedAt = DeletedAt::now();

        // TODO: Record WorkEntryRemoved Domain Event.
    }

    private function guardEndIsAfterStart(): void
    {
        if ($this->end() === null) {
            return;
        }

        if ($this->start()->value() < $this->end()->value()) {
            return;
        }

        throw InvalidInterval::forEndBeforeStart($this->start()->value(), $this->end()->value());
    }
}
