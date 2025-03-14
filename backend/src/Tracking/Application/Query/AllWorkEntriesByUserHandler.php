<?php

namespace Core\Tracking\Application\Query;

use Core\Shared\Application\View\ListView;
use Core\Shared\Application\View\ViewInterface;
use Core\Shared\Domain\Bus\QueryHandlerInterface;
use Core\Tracking\Application\View\WorkEntryView;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Persistence\WorkEntryRepositoryInterface;

final class AllWorkEntriesByUserHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly WorkEntryRepositoryInterface $repo,
    )
    {
    }

    public function __invoke(AllWorkEntriesByUserQuery $query): ViewInterface
    {
        $entries = $this->repo->matching(['user' => $query->user, 'deletedAt' => null]);

        return ListView::fromList(
            array_map(
                static fn(WorkEntry $entry) => WorkEntryView::fromWorkEntry($entry),
                $entries,
            ),
        );
    }
}
