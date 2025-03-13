<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Domain\Entity\TimestampValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class TimestampType extends ValueObjectType
{
    /** @return class-string<TimestampValueObject> */
    abstract protected function getValueObjectClass(): string;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    protected function createValueObject(mixed $value): TimestampValueObject
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException("Provided value is not an int. Actual: $value");
        }

        /** @var class-string<TimestampValueObject> $class */
        $class = $this->getValueObjectClass();

        return $class::fromValue($value);
    }

    protected function getValueObjectValue(mixed $value): int
    {
        $class = $this->getValueObjectClass();
        if (!$value instanceof TimestampValueObject || !$value instanceof $class) {
            throw new \InvalidArgumentException('The value object must extend ' . $class);
        }

        return $value->value();
    }
}
