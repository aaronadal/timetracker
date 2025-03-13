<?php

namespace Core\Shared\Domain\Entity;

/** @template T */
abstract class ValueObject
{
    public abstract static function fromValue(mixed $value): static;

    /** @var T */
    private readonly mixed $value;

    /** @param T $value */
    protected final function __construct(mixed $value)
    {
        /** @var T $value */
        $value = $this->ensureIsValid($value);

        $this->value = $value;
    }

    /**
     * @param T $value
     *
     * @return T
     */
    protected function ensureIsValid(mixed $value): mixed
    {
        return $value;
    }

    /** @return T */
    public function value(): mixed
    {
        return $this->value;
    }

    public function toString(): string
    {
        return "{$this->value()}";
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof $this && $this->value() === $other->value();
    }
}
