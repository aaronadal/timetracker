<?php

namespace Core\Shared\Domain\Entity;

use Core\Shared\Domain\Exception\InvalidValueException;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

/** @extends ValueObject<string> */
abstract class UuidValueObject extends ValueObject
{
    public static function fromValue(mixed $value): static
    {
        return new static("$value");
    }

    public static function random(): static
    {
        return new static(Uuid::v4()->toRfc4122());
    }

    protected function ensureIsValid(mixed $value): mixed
    {
        if(!UuidV4::isValid($value)) {
            throw InvalidValueException::forExpectedFormat($value, 'UUID v4');
        }

        return $value;
    }
}
