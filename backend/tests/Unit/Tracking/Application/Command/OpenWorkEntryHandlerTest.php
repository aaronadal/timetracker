<?php

namespace Test\Unit\Tracking\Application\Command;

use Core\Auth\Application\View\UserView;
use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\UpdatedAt;
use Core\Shared\Domain\Exception\EntityNotFound;
use Core\Shared\Domain\TimestampProvider;
use Core\Tracking\Application\Command\OpenWorkEntryHandler;
use Core\Tracking\Domain\Exception\OpenWorkEntryAlreadyExists;
use Test\Mocker\Shared\Domain\Bus\QueryBusMocker;
use Test\Mocker\Tracking\Domain\Persistence\WorkEntryRepositoryMocker;
use Test\Mother\Auth\Application\Query\UserByIdQueryMother;
use Test\Mother\Auth\Domain\Entity\UserMother;
use Test\Mother\TimestampMother;
use Test\Mother\Tracking\Application\Command\OpenWorkEntryCommandMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryMother;
use Test\Unit\UnitTest;

final class OpenWorkEntryHandlerTest extends UnitTest
{
    private int $now;
    private WorkEntryRepositoryMocker $repo;
    private QueryBusMocker $queryBus;
    private OpenWorkEntryHandler $handler;

    protected function setUp(): void
    {
        $this->now = TimestampMother::lastFewMinutes();
        TimestampProvider::mock($this->now);

        $this->repo = new WorkEntryRepositoryMocker();
        $this->queryBus = new QueryBusMocker();
        $this->handler = new OpenWorkEntryHandler(
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
        $command = OpenWorkEntryCommandMother::create();

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
        $command = OpenWorkEntryCommandMother::create();
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));

        $exception = OpenWorkEntryAlreadyExists::forUser($command->user);

        $this->queryBus->ask(
            UserByIdQueryMother::create($command->user->value()),
            UserView::fromUser($user),
        );
        $this->repo->matching(
            ['user' => $command->user->value(), 'close' => null, 'deletedAt' => null],
            [WorkEntryMother::createOpen(user: $command->user)],
        );
        $this->repo->notSave();

        $this->expectExceptionObject($exception);
        ($this->handler)($command);
    }

    public function testSignsUpSuccessfully(): void
    {
        $command = OpenWorkEntryCommandMother::create();
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));
        $entry = WorkEntryMother::createOpen(
            id: $command->id,
            user: $command->user,
            start: $command->start,
            createdAt: CreatedAt::fromValue($this->now),
            updatedAt: UpdatedAt::fromValue($this->now),
        );

        $this->queryBus->ask(
            UserByIdQueryMother::create($command->user->value()),
            UserView::fromUser($user),
        );
        $this->repo->matching(
            ['user' => $command->user->value(), 'close' => null, 'deletedAt' => null],
            [],
        );
        $this->repo->save($entry);

        ($this->handler)($command);
    }
}
