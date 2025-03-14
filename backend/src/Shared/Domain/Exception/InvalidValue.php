<?php

namespace Core\Shared\Domain\Exception;

final class InvalidValue extends DomainException
{
    protected static function statusCode(): int
    {
        return 400;
    }

    public static function forEmptyValue(): self
    {
        return new self(
            "The value cannot be empty",
        );
    }

    public static function forFutureValue(): self
    {
        return new self(
            "The value cannot be in the future",
        );
    }

    public static function forExpectedType(string $value, string $expectedType): self
    {
        return new self(
            "Invalid type for value <$value>: <$expectedType> expected",
        );
    }

    public static function forExpectedFormat(string $value, string $expectedFormat): self
    {
        return new self(
            "Invalid format for value <$value>: <$expectedFormat> expected",
        );
    }

    public static function forDuplicatedValue(string $value): self
    {
        return new self(
            "The value <$value> already exists",
        );
    }
}
