<?php

namespace Test\Unit\Tracking\Application\Query;

use Core\Shared\Application\View\ListView;
use Core\Shared\Domain\Exception\EntityNotFound;
use Core\Tracking\Application\Query\AllWorkEntriesByUserHandler;
use Core\Tracking\Application\Query\WorkEntryByUserAndIdHandler;
use Core\Tracking\Application\View\WorkEntryView;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Test\Mocker\Tracking\Domain\Persistence\WorkEntryRepositoryMocker;
use Test\Mother\MultipleMother;
use Test\Mother\Tracking\Application\Query\AllWorkEntriesByUserQueryMother;
use Test\Mother\Tracking\Application\Query\WorkEntryByUserAndIdQueryMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryMother;
use Test\Unit\UnitTest;

final class WorkEntryByUserAndIdHandlerTest extends UnitTest
{
    private WorkEntryRepositoryMocker $repo;
    private WorkEntryByUserAndIdHandler $handler;

    protected function setUp(): void
    {
        $this->repo = new WorkEntryRepositoryMocker();
        $this->handler = new WorkEntryByUserAndIdHandler(
            $this->repo->mock(),
        );
    }

    public function testFailsIfEntryNotFound(): void
    {
        $query = WorkEntryByUserAndIdQueryMother::create();

        $exception = EntityNotFound::forClassAndId(WorkEntry::class, WorkEntryId::fromValue($query->id));

        $this->repo->matching(['id' => $query->id, 'user' => $query->user, 'deletedAt' => null], []);

        self::expectExceptionObject($exception);
        $view = ($this->handler)($query);
    }

    public function testReturnsEntriesSuccessfully(): void
    {
        $query = WorkEntryByUserAndIdQueryMother::create();
        $entry = WorkEntryMother::createNotDeleted(
            id: WorkEntryId::fromValue($query->id),
            user: WorkEntryUserId::fromValue($query->user),
        );

        $this->repo->matching(['id' => $query->id, 'user' => $query->user, 'deletedAt' => null], [$entry]);

        $view = ($this->handler)($query);

        self::assertInstanceOf(WorkEntryView::class, $view);
        self::assertEquals($entry->id()->value(), $view->id);
        self::assertEquals($entry->user()->value(), $view->user);
        self::assertEquals($entry->start()->value(), $view->start);
        self::assertEquals($entry->end()?->value(), $view->end);
        self::assertEquals($entry->createdAt()->value(), $view->createdAt);
        self::assertEquals($entry->updatedAt()->value(), $view->updatedAt);
    }
}
