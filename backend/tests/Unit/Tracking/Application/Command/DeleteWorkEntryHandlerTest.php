<?php

namespace Test\Unit\Tracking\Application\Command;

use Core\Auth\Application\View\UserView;
use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\UpdatedAt;
use Core\Shared\Domain\Exception\EntityNotFound;
use Core\Shared\Domain\TimestampProvider;
use Core\Tracking\Application\Command\DeleteWorkEntryHandler;
use Core\Tracking\Domain\Entity\WorkEntry;
use Test\Mocker\Shared\Domain\Bus\QueryBusMocker;
use Test\Mocker\Tracking\Domain\Persistence\WorkEntryRepositoryMocker;
use Test\Mother\Auth\Application\Query\UserByIdQueryMother;
use Test\Mother\Auth\Domain\Entity\UserMother;
use Test\Mother\TimestampMother;
use Test\Mother\Tracking\Application\Command\DeleteWorkEntryCommandMother;
use Test\Mother\Tracking\Domain\Entry\WorkEntryMother;
use Test\Unit\UnitTest;

final class DeleteWorkEntryHandlerTest extends UnitTest
{
    private int $now;
    private WorkEntryRepositoryMocker $repo;
    private QueryBusMocker $queryBus;
    private DeleteWorkEntryHandler $handler;

    protected function setUp(): void
    {
        $this->now = TimestampMother::lastFewMinutes();
        TimestampProvider::mock($this->now);

        $this->repo = new WorkEntryRepositoryMocker();
        $this->queryBus = new QueryBusMocker();
        $this->handler = new DeleteWorkEntryHandler(
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
        $command = DeleteWorkEntryCommandMother::create();

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
        $command = DeleteWorkEntryCommandMother::create();
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

    public function testDeletesWorkEntrySuccessfully(): void
    {
        $command = DeleteWorkEntryCommandMother::create();
        $user = UserMother::createNotDeleted(UserId::fromValue($command->user->value()));
        $entry = WorkEntryMother::createNotDeleted(
            id: $command->id,
            user: $command->user,
            createdAt: CreatedAt::fromValue($this->now),
            updatedAt: UpdatedAt::fromValue($this->now),
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
    }
}
