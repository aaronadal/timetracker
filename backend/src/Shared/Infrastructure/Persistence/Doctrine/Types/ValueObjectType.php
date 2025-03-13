<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class ValueObjectType extends AbstractType
{
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        return $this->getValueObjectValue($value);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        return $this->createValueObject($value);
    }

    abstract protected function createValueObject(mixed $value): mixed;

    abstract protected function getValueObjectValue(mixed $value): mixed;
}
