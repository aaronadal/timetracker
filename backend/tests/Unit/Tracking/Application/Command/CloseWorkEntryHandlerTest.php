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
use Core\Tracking\Application\Command\CloseWorkEntryHandler;
use Core\Tracking\Domain\Exception\OpenWorkEntryNotFound;
use Test\Mocker\Shared\Domain\Bus\QueryBusMocker;
use Test\Mocker\Tracking\Domain\Persistence\WorkEntryRepositoryMocker;
use Test\Mother\Auth\Application\Query\UserByIdQueryMother;
use Test\Mother\Auth\Domain\Entity\UserMother;
use Test\Mother\TimestampMother;
use Test\Mother\Tracking\Application\Command\CloseWorkEntryCommandMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryStartMother;
use Test\Unit\UnitTest;

final class CloseWorkEntryHandlerTest extends UnitTest
{
    private int $now;
    private WorkEntryRepositoryMocker $repo;
    private QueryBusMocker $queryBus;
    private CloseWorkEntryHandler $handler;

    protected function setUp(): void
    {
        $this->now = TimestampMother::lastFewMinutes();
        TimestampProvider::mock($this->now);

        $this->repo = new WorkEntryRepositoryMocker();
        $this->queryBus = new QueryBusMocker();
        $this->handler = new CloseWorkEntryHandler(
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
        $command = CloseWorkEntryCommandMother::create();

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

    public function testFailsIfAnotherOpenEntryFound(): void
    {
        $command = CloseWorkEntryCommandMother::create();
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));

        $exception = OpenWorkEntryNotFound::forUser($command->user);

        $this->queryBus->ask(
            UserByIdQueryMother::create($command->user->value()),
            UserView::fromUser($user),
        );
        $this->repo->matching(
            ['user' => $command->user->value(), 'end' => null, 'deletedAt' => null],
            [],
        );
        $this->repo->notSave();

        $this->expectExceptionObject($exception);
        ($this->handler)($command);
    }

    public function testFailsIfEndIsBeforeStart(): void
    {
        $command = CloseWorkEntryCommandMother::create();
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));
        $entry = WorkEntryMother::createOpen(
            user: $command->user,
            start: WorkEntryStartMother::after($command->end->value()),
            createdAt: CreatedAt::fromValue($this->now),
            updatedAt: UpdatedAt::fromValue($this->now),
        );

        $exception = InvalidInterval::forEndBeforeStart($entry->start()->value(), $command->end->value());

        $this->queryBus->ask(
            UserByIdQueryMother::create($command->user->value()),
            UserView::fromUser($user),
        );
        $this->repo->matching(
            ['user' => $command->user->value(), 'end' => null, 'deletedAt' => null],
            [$entry],
        );
        $this->repo->notSave();

        $this->expectExceptionObject($exception);
        ($this->handler)($command);
    }

    public function testClosesWorkEntrySuccessfully(): void
    {
        $command = CloseWorkEntryCommandMother::create();
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));
        $entry = WorkEntryMother::createOpen(
            user: $command->user,
            start: WorkEntryStartMother::before($command->end->value()),
            createdAt: CreatedAt::fromValue($this->now),
            updatedAt: UpdatedAt::fromValue($this->now),
        );

        $this->queryBus->ask(
            UserByIdQueryMother::create($command->user->value()),
            UserView::fromUser($user),
        );
        $this->repo->matching(
            ['user' => $command->user->value(), 'end' => null, 'deletedAt' => null],
            [$entry],
        );
        $this->repo->save($entry);

        ($this->handler)($command);

        self::assertEquals($command->end->value(), $entry->end()?->value());
        self::assertEquals(TimestampProvider::now(), $entry->updatedAt()->value());
    }
}
