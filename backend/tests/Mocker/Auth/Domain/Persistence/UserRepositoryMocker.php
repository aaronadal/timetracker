<?php

namespace Test\Mocker\Auth\Domain\Persistence;

use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Persistence\UserRepositoryInterface;
use Test\Mocker\Mocker;
use Test\Unit\Shared\Infrastructure\Testing\Mockery\IsSimilarToMatcher;

/** @extends Mocker<UserRepositoryInterface> */
final class UserRepositoryMocker extends Mocker
{
    public function class(): string
    {
        return UserRepositoryInterface::class;
    }

    public function save(User $user): void
    {
        $this->mock()
            ->shouldReceive('save')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($user));
    }

    public function notSave(): void
    {
        $this->mock()
            ->shouldNotReceive('save');
    }

    public function exists(UserId $id): void
    {
        $this->mock()
            ->shouldReceive('exists')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($id))
            ->andReturnTrue();
    }

    public function notExists(UserId $id): void
    {
        $this->mock()
            ->shouldReceive('exists')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($id))
            ->andReturnFalse();
    }

    public function found(UserId $id, User $user): void
    {
        $this->mock()
            ->shouldReceive('search')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($id))
            ->andReturn($user);
    }

    public function notFound(UserId $id): void
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
     * @param list<User> $result
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
