<?php

namespace Test\Mocker\Tracking\Domain\Persistence;

use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Persistence\UserRepositoryInterface;
use Core\Tracking\Domain\Entity\WorkEntry;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Persistence\WorkEntryRepositoryInterface;
use Test\Mocker\Mocker;
use Test\Unit\Shared\Infrastructure\Testing\Mockery\IsSimilarToMatcher;

/** @extends Mocker<WorkEntryRepositoryInterface> */
final class WorkEntryRepositoryMocker extends Mocker
{
    public function class(): string
    {
        return WorkEntryRepositoryInterface::class;
    }

    public function save(WorkEntry $entry): void
    {
        $this->mock()
            ->shouldReceive('save')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($entry));
    }

    public function notSave(): void
    {
        $this->mock()
            ->shouldNotReceive('save');
    }

    public function exists(WorkEntryId $id): void
    {
        $this->mock()
            ->shouldReceive('exists')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($id))
            ->andReturnTrue();
    }

    public function notExists(WorkEntryId $id): void
    {
        $this->mock()
            ->shouldReceive('exists')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($id))
            ->andReturnFalse();
    }

    public function found(WorkEntryId $id, WorkEntry $entry): void
    {
        $this->mock()
            ->shouldReceive('search')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($id))
            ->andReturn($entry);
    }

    public function notFound(WorkEntryId $id): void
    {
        $this->mock()
            ->shouldReceive('search')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($id))
            ->andReturnNull();

    }

    /**
     * @param non-empty-array<string, scalar|null> $criteria
     * @param list<WorkEntry> $result
     */
    public function matching(array $criteria, array $result): void
    {
        $this->mock()
            ->shouldReceive('matching')
            ->once()
            ->ordered()
            ->with($criteria)
            ->andReturn($result);
    }
}
