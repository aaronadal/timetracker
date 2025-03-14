<?php

namespace Core\Shared\Domain\Exception;

use Core\Shared\Domain\Entity\AggregateRoot;
use Core\Shared\Domain\Entity\UuidValueObject;

final class EntityNotFound extends DomainException
{
    /** @param class-string<AggregateRoot> $class */
    public static function forClassAndId(string $class, UuidValueObject $id, ?\Throwable $previous = null): static
    {
        return new static(
            "The <$class> with ID <{$id->value()}> cannot be found",
            $previous,
        );
    }

    protected static function statusCode(): int
    {
        return 404;
    }
}
