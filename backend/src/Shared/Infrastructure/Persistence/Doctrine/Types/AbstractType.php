<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Types\Type;

abstract class AbstractType extends Type
{
    abstract public static function name(): string;

    public function getName(): string
    {
        return static::name();
    }
}
