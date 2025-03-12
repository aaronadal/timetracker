<?php

namespace Core\Shared\Domain\Entity;

use Core\Shared\Domain\Exception\InvalidValueException;
use Symfony\Component\Uid\UuidV4;

/** @extends ValueObject<string> */
abstract class UuidValueObject extends ValueObject
{
    public static function fromValue(mixed $value): static
    {
        return new static("$value");
    }

    protected function ensureIsValid(mixed $value): mixed
    {
        if(!UuidV4::isValid($value)) {
            throw InvalidValueException::forExpectedFormat($value, 'UUID v4');
        }

        return $value;
    }
}
