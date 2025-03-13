<?php

namespace Core\Shared\Domain\Entity;

abstract class AggregateRoot
{
    public abstract function id(): UuidValueObject;

    public abstract function createdAt(): CreatedAt;

    public abstract function updatedAt(): UpdatedAt;

    public abstract function deletedAt(): ?DeletedAt;
}
