<?php

namespace Test\Mother;

/**
 * @template V
 */
final class Nullable
{
    /**
     * @template T
     *
     * @param T $value
     *
     * @return T|null
     */
    public static function make(mixed $value): mixed
    {
        return self::resolve(
            self::maybeNull(),
            static fn () => $value,
        );
    }

    /**
     * @template T
     *
     * @param callable(): T $generator
     *
     * @return T|null
     */
    public static function resolve(mixed $nullable, callable $generator): mixed
    {
        if (null === $nullable) {
            $nullable = Nullable::maybeNull();
        }

        if (!$nullable instanceof Nullable) {
            $nullable = Nullable::value($nullable);
        }

        /** @var Nullable<T>|Nullable<null> $nullable */
        if (NullableMode::VALUE === $nullable->mode) {
            return $nullable->value;
        }

        if (NullableMode::NOT_NULL === $nullable->mode) {
            return $generator();
        }

        return (FakerCreator::get()->boolean()) ? null : $generator();
    }

    /** @return self<null> */
    public static function maybeNull(): self
    {
        return new self(NullableMode::MAYBE_NULL, null);
    }

    /** @return self<null> */
    public static function notNull(): self
    {
        return new self(NullableMode::NOT_NULL, null);
    }

    /** @return self<null> */
    public static function null(): self
    {
        return new self(NullableMode::VALUE, null);
    }

    /**
     * @template T
     *
     * @param T $value
     *
     * @return self<T>
     */
    public static function value(mixed $value): self
    {
        return new self(NullableMode::VALUE, $value);
    }

    /** @param V $value */
    private function __construct(
        private readonly NullableMode $mode,
        private readonly mixed $value,
    ) {
    }
}
