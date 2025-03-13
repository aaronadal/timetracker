<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Domain\Entity\StringValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class StringType extends ValueObjectType
{
    /** @return class-string<StringValueObject> */
    abstract protected function getValueObjectClass(): string;

    protected function createValueObject(mixed $value): StringValueObject
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException();
        }

        /** @var class-string<StringValueObject> $class */
        $class = $this->getValueObjectClass();

        return $class::fromValue($value);
    }

    protected function getValueObjectValue(mixed $value): string
    {
        $class = $this->getValueObjectClass();
        if (!$value instanceof StringValueObject || !$value instanceof $class) {
            throw new \InvalidArgumentException('The value object must extend ' . $class);
        }

        return $value->value();
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }
}
