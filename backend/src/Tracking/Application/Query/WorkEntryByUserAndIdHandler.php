<?php

namespace Core\Tracking\Application\Query;

use Core\Shared\Application\View\ViewInterface;
use Core\Shared\Domain\Bus\QueryHandlerInterface;
use Core\Shared\Domain\Exception\EntityNotFound;
use Core\Tracking\Application\View\WorkEntryView;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Persistence\WorkEntryRepositoryInterface;

final class WorkEntryByUserAndIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly WorkEntryRepositoryInterface $repo,
    )
    {
    }

    public function __invoke(WorkEntryByUserAndIdQuery $query): ViewInterface
    {
        $id = WorkEntryId::fromValue($query->id);
        $entries = $this->repo->matching(['id' => $query->id, 'user' => $query->user, 'deletedAt' => null]);
        if(count($entries) === 0) {
            throw EntityNotFound::forClassAndId(WorkEntry::class, $id);
        }

        return WorkEntryView::fromWorkEntry($entries[0]);
    }
}
