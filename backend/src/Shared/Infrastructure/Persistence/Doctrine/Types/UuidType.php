<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Domain\Entity\UuidValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class UuidType extends ValueObjectType
{
    /** @return class-string<UuidValueObject> */
    abstract protected function getValueObjectClass(): string;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'CHAR(36)';
    }

    protected function createValueObject(mixed $value): UuidValueObject
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException("Provided value is not a string. Actual: $value");
        }

        /** @var class-string<UuidValueObject> $class */
        $class = $this->getValueObjectClass();

        return $class::fromValue($value);
    }

    protected function getValueObjectValue(mixed $value): string
    {
        $class = $this->getValueObjectClass();
        if (!$value instanceof UuidValueObject || !$value instanceof $class) {
            throw new \InvalidArgumentException('The value object must extend ' . $class);
        }

        return $value->value();
    }
}
