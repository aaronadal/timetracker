<?php

namespace Core\Tracking\Application\Query;

use Core\Shared\Application\View\ListView;
use Core\Shared\Domain\Bus\QueryInterface;
use Core\Tracking\Application\View\WorkEntryView;

/** @implements QueryInterface<ListView<WorkEntryView>> */
final class AllWorkEntriesByUserQuery implements QueryInterface
{
    public function __construct(
        public readonly string $user,
    )
    {
    }
}
