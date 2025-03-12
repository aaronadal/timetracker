<?php

namespace Core\Shared\Domain\Entity;

abstract class AggregateRoot
{
    public abstract function id(): UuidValueObject;

    public abstract function createdAt(): TimestampValueObject;

    public abstract function updatedAt(): TimestampValueObject;

    public abstract function deletedAt(): ?TimestampValueObject;
}
