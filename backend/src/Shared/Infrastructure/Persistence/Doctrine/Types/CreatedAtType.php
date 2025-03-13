<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Domain\Entity\CreatedAt;

final class CreatedAtType extends TimestampType
{
    public static function name(): string
    {
        return 'shared.created_at';
    }

    protected function getValueObjectClass(): string
    {
        return CreatedAt::class;
    }
}