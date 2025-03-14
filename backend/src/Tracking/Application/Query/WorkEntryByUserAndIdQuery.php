<?php

namespace Core\Tracking\Application\Query;

use Core\Shared\Domain\Bus\QueryInterface;
use Core\Tracking\Application\View\WorkEntryView;

/** @implements QueryInterface<WorkEntryView> */
final class WorkEntryByUserAndIdQuery implements QueryInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $user,
    )
    {
    }
}
