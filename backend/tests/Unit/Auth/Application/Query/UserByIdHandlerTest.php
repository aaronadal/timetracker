<?php

namespace Test\Unit\Auth\Application\Query;

use Core\Auth\Application\Query\UserByIdHandler;
use Core\Auth\Application\View\UserView;
use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Shared\Domain\Exception\EntityNotFound;
use Test\Mocker\Auth\Domain\Persistence\UserRepositoryMocker;
use Test\Mother\Auth\Application\Query\UserByIdQueryMother;
use Test\Mother\Auth\Domain\Entity\UserMother;
use Test\Unit\UnitTest;

final class UserByIdHandlerTest extends UnitTest
{
    private UserRepositoryMocker $repo;
    private UserByIdHandler $handler;

    protected function setUp(): void
    {
        $this->repo = new UserRepositoryMocker();
        $this->handler = new UserByIdHandler(
            repo: $this->repo->mock(),
        );
    }

    public function testFailsIfUserNotFound(): void
    {
        $query = UserByIdQueryMother::create();
        $id = UserId::fromValue($query->id);

        $this->repo->matching(['id' => $query->id, 'deletedAt' => null], []);

        self::expectExceptionObject(EntityNotFound::forClassAndId(User::class, $id));
        ($this->handler)($query);
    }

    public function testReturnsUserSuccessfully(): void
    {
        $query = UserByIdQueryMother::create();
        $user = UserMother::createNotDeleted(
            id: UserId::fromValue($query->id),
        );

        $this->repo->matching(['id' => $query->id, 'deletedAt' => null], [$user]);

        $view = ($this->handler)($query);

        self::assertInstanceOf(UserView::class, $view);
        self::assertEquals($user->id()->value(), $view->id);
        self::assertEquals($user->name()->value(), $view->name);
        self::assertEquals($user->createdAt()->value(), $view->createdAt);
        self::assertEquals($user->updatedAt()->value(), $view->updatedAt);
    }
}
