<?php

namespace Core\Auth\Application\View;

use Core\Auth\Domain\Entity\User;
use Core\Shared\Application\View\PublicPropertiesViewTrait;
use Core\Shared\Application\View\ViewInterface;

final class UserView implements ViewInterface
{
    use PublicPropertiesViewTrait;

    public static function fromUser(User $user): self
    {
        return new self(
            id: $user->id()->value(),
            name: $user->name()->value(),
            createdAt: $user->createdAt()->value(),
            updatedAt: $user->updatedAt()->value(),
        );
    }

    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $createdAt,
        public readonly int $updatedAt,
    ) {
    }
}
