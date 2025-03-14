<?php

namespace Core\Tracking\Application\View;

use Core\Shared\Application\View\PublicPropertiesViewTrait;
use Core\Shared\Application\View\ViewInterface;
use Core\Tracking\Domain\Entity\WorkEntry;

final class WorkEntryView implements ViewInterface
{
    use PublicPropertiesViewTrait;

    public static function fromWorkEntry(WorkEntry $entry): self
    {
        return new self(
            id: $entry->id()->value(),
            user: $entry->user()->value(),
            start: $entry->start()->value(),
            end: $entry->end()?->value(),
            createdAt: $entry->createdAt()->value(),
            updatedAt: $entry->updatedAt()->value(),
        );
    }

    private function __construct(
        public readonly string $id,
        public readonly string $user,
        public readonly int $start,
        public readonly ?int $end,
        public readonly int $createdAt,
        public readonly int $updatedAt,
    )
    {
    }
}
