<?php

namespace Core\Shared\Domain\Entity;

use Core\Shared\Domain\Exception\InvalidValue;

/** @extends ValueObject<string> */
abstract class StringValueObject extends ValueObject
{
    public static function fromValue(mixed $value): static
    {
        return new static("$value");
    }

    protected static function canBeEmpty(): bool
    {
        return false;
    }

    protected function ensureIsValid(mixed $value): mixed
    {
        if(!static::canBeEmpty() && $value === '') {
            throw InvalidValue::forEmptyValue();
        }

        return $value;
    }
}
