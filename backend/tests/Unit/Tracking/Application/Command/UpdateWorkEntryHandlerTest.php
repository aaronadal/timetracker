<?php

namespace Test\Unit\Tracking\Application\Command;

use Core\Auth\Application\View\UserView;
use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\UpdatedAt;
use Core\Shared\Domain\Exception\EntityNotFound;
use Core\Shared\Domain\Exception\InvalidInterval;
use Core\Shared\Domain\TimestampProvider;
use Core\Tracking\Application\Command\UpdateWorkEntryHandler;
use Core\Tracking\Domain\Entity\WorkEntry;
use Test\Mocker\Shared\Domain\Bus\QueryBusMocker;
use Test\Mocker\Tracking\Domain\Persistence\WorkEntryRepositoryMocker;
use Test\Mother\Auth\Application\Query\UserByIdQueryMother;
use Test\Mother\Auth\Domain\Entity\UserMother;
use Test\Mother\TimestampMother;
use Test\Mother\Tracking\Application\Command\UpdateWorkEntryCommandMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryEndMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryStartMother;
use Test\Unit\UnitTest;

final class UpdateWorkEntryHandlerTest extends UnitTest
{
    private int $now;
    private WorkEntryRepositoryMocker $repo;
    private QueryBusMocker $queryBus;
    private UpdateWorkEntryHandler $handler;

    protected function setUp(): void
    {
        $this->now = TimestampMother::lastFewMinutes();
        TimestampProvider::mock($this->now);

        $this->repo = new WorkEntryRepositoryMocker();
        $this->queryBus = new QueryBusMocker();
        $this->handler = new UpdateWorkEntryHandler(
            repo: $this->repo->mock(),
            queryBus: $this->queryBus->mock(),
        );
    }

    protected function tearDown(): void
    {
        TimestampProvider::clear();
    }

    public function testFailsIfUserDoesNotExist(): void
    {
        $command = UpdateWorkEntryCommandMother::create();

        $exception = EntityNotFound::forClassAndId(
            User::class,
            UserId::fromValue($command->user->value()),
        );

        $this->queryBus->askAndFail(
            UserByIdQueryMother::create($command->user->value()),
            $exception,
        );
        $this->repo->notSave();

        $this->expectExceptionObject($exception);
        ($this->handler)($command);
    }

    public function testFailsIfEntryDoesNotExist(): void
    {
        $end = WorkEntryEndMother::random();
        $start = WorkEntryStartMother::after($end->value());
        $command = UpdateWorkEntryCommandMother::create(
            start: $start,
            end: $end,
        );
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));

        $exception = EntityNotFound::forClassAndId(WorkEntry::class, $command->id);

        $this->queryBus->ask(
            UserByIdQueryMother::create($command->user->value()),
            UserView::fromUser($user),
        );
        $this->repo->matching(
            ['id' => $command->id->value(), 'user' => $command->user->value(), 'deletedAt' => null],
            [],
        );
        $this->repo->notSave();

        $this->expectExceptionObject($exception);
        ($this->handler)($command);
    }

    public function testFailsIfEndIsBeforeStart(): void
    {
        $end = WorkEntryEndMother::random();
        $start = WorkEntryStartMother::after($end->value());
        $command = UpdateWorkEntryCommandMother::create(
            start: $start,
            end: $end,
        );
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));
        $entry = WorkEntryMother::createNotDeleted(
            id: $command->id,
            user: $command->user,
            start: $start,
            end: $end,
        );

        $exception = InvalidInterval::forEndBeforeStart($start->value(), $end->value());

        $this->queryBus->ask(
            UserByIdQueryMother::create($command->user->value()),
            UserView::fromUser($user),
        );
        $this->repo->matching(
            ['id' => $command->id->value(), 'user' => $command->user->value(), 'deletedAt' => null],
            [$entry],
        );
        $this->repo->notSave();

        $this->expectExceptionObject($exception);
        ($this->handler)($command);
    }

    public function testUpdatesWorkEntrySuccessfully(): void
    {
        $end = WorkEntryEndMother::random();
        $start = WorkEntryStartMother::before($end->value());
        $command = UpdateWorkEntryCommandMother::create(
            start: $start,
            end: $end,
        );
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));
        $entry = WorkEntryMother::createNotDeleted(
            id: $command->id,
            user: $command->user,
            start: WorkEntryStartMother::different($start),
            end: WorkEntryEndMother::different($end),
        );

        $this->queryBus->ask(
            UserByIdQueryMother::create($command->user->value()),
            UserView::fromUser($user),
        );
        $this->repo->matching(
            ['id' => $command->id->value(), 'user' => $command->user->value(), 'deletedAt' => null],
            [$entry],
        );
        $this->repo->save($entry);

        ($this->handler)($command);

        self::assertEquals($command->start->value(), $entry->start()->value());
        self::assertEquals($command->end?->value(), $entry->end()?->value());
        self::assertEquals(TimestampProvider::now(), $entry->updatedAt()->value());
    }
}
