<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine;

use Core\Shared\Domain\Entity\AggregateRoot;

interface DoctrineRepositoryInterface
{
    /** @return class-string<AggregateRoot> */
    public function entityClass(): string;
}
