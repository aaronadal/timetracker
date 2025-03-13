<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Domain\Entity\UpdatedAt;

final class UpdatedAtType extends TimestampType
{
    public static function name(): string
    {
        return 'shared.updated_at';
    }

    protected function getValueObjectClass(): string
    {
        return UpdatedAt::class;
    }
}