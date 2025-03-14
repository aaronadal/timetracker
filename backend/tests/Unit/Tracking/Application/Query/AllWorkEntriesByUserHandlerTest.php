<?php

namespace Test\Unit\Tracking\Application\Query;

use Core\Shared\Application\View\ListView;
use Core\Tracking\Application\Query\AllWorkEntriesByUserHandler;
use Core\Tracking\Application\View\WorkEntryView;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Test\Mocker\Tracking\Domain\Persistence\WorkEntryRepositoryMocker;
use Test\Mother\MultipleMother;
use Test\Mother\Tracking\Application\Query\AllWorkEntriesByUserQueryMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryMother;
use Test\Unit\UnitTest;

final class AllWorkEntriesByUserHandlerTest extends UnitTest
{
    private WorkEntryRepositoryMocker $repo;
    private AllWorkEntriesByUserHandler $handler;

    protected function setUp(): void
    {
        $this->repo = new WorkEntryRepositoryMocker();
        $this->handler = new AllWorkEntriesByUserHandler(
            $this->repo->mock(),
        );
    }

    public function testReturnsEntriesSuccessfully(): void
    {
        $query = AllWorkEntriesByUserQueryMother::create();
        $entries = MultipleMother::random(
            static fn() => WorkEntryMother::createNotDeleted(
                user: WorkEntryUserId::fromValue($query->user),
            ),
        );

        $this->repo->matching(['user' => $query->user, 'deletedAt' => null], $entries);

        $view = ($this->handler)($query);

        self::assertInstanceOf(ListView::class, $view);
        self::assertCount(count($entries), $view->items);
        foreach ($view->items as $index => $entryView) {
            self::assertInstanceOf(WorkEntryView::class, $entryView);

            $entry = $entries[$index];
            self::assertEquals($entry->id()->value(), $entryView->id);
            self::assertEquals($entry->user()->value(), $entryView->user);
            self::assertEquals($entry->start()->value(), $entryView->start);
            self::assertEquals($entry->end()?->value(), $entryView->end);
            self::assertEquals($entry->createdAt()->value(), $entryView->createdAt);
            self::assertEquals($entry->updatedAt()->value(), $entryView->updatedAt);
        }
    }
}
