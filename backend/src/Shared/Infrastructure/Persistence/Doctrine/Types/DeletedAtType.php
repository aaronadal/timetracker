<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine\Types;

use Core\Shared\Domain\Entity\DeletedAt;

final class DeletedAtType extends TimestampType
{
    public static function name(): string
    {
        return 'shared.deleted_at';
    }

    protected function getValueObjectClass(): string
    {
        return DeletedAt::class;
    }
}