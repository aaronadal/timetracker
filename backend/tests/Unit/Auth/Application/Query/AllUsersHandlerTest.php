<?php

namespace Test\Unit\Auth\Application\Query;

use Core\Auth\Application\Query\AllUsersHandler;
use Core\Auth\Application\Query\AllUsersQuery;
use Core\Auth\Application\View\UserView;
use Core\Shared\Application\View\ListView;
use Core\Shared\Application\View\ViewInterface;
use Test\Mocker\Auth\Domain\Persistence\UserRepositoryMocker;
use Test\Mother\Auth\Domain\Entity\UserMother;
use Test\Mother\MultipleMother;
use Test\Unit\UnitTest;

final class AllUsersHandlerTest extends UnitTest
{
    private UserRepositoryMocker $repo;
    private AllUsersHandler $handler;

    protected function setUp(): void
    {
        $this->repo = new UserRepositoryMocker();
        $this->handler = new AllUsersHandler(
            repo: $this->repo->mock(),
        );
    }

    public function testReturnsUsersSuccessfully(): void
    {
        $query = new AllUsersQuery();
        $users = MultipleMother::random(
            static fn() => UserMother::createNotDeleted(),
        );

        $this->repo->matching(['deletedAt' => null], $users);

        /** @var ListView<ViewInterface> $view */
        $view = ($this->handler)($query);

        self::assertCount(count($users), $view->items);
        foreach ($view->items as $index => $userView) {
            self::assertInstanceOf(UserView::class, $userView);

            $user = $users[$index];
            self::assertEquals($user->id()->value(), $userView->id);
            self::assertEquals($user->name()->value(), $userView->name);
            self::assertEquals($user->createdAt()->value(), $userView->createdAt);
            self::assertEquals($user->updatedAt()->value(), $userView->updatedAt);
        }
    }
}
