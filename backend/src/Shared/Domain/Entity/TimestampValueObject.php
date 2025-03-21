<?php

namespace Core\Shared\Domain\Entity;

use Core\Shared\Domain\Exception\InvalidValue;
use Core\Shared\Domain\TimestampProvider;

/** @extends ValueObject<int> */
abstract class TimestampValueObject extends ValueObject
{
    public static function fromValue(mixed $value): static
    {
        if(!is_numeric($value)) {
            throw InvalidValue::forExpectedType("$value", 'timestamp');
        }

        return new static(intval($value));
    }

    public static function now(): static
    {
        return static::fromValue(TimestampProvider::now());
    }

    protected static function canBeFuture(): bool
    {
        return false;
    }

    protected function ensureIsValid(mixed $value): mixed
    {
        if(!static::canBeFuture() && $value > TimestampProvider::now()) {
            throw InvalidValue::forFutureValue();
        }

        return $value;
    }
}
