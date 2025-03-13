<?php

namespace Core\Auth\Application\Query;

use Core\Auth\Application\View\UserView;
use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Persistence\UserRepositoryInterface;
use Core\Shared\Application\View\ListView;
use Core\Shared\Application\View\ViewInterface;
use Core\Shared\Domain\Bus\QueryHandlerInterface;

final class AllUsersHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repo,
    ) {
    }

    public function __invoke(AllUsersQuery $query): ViewInterface
    {
        $users = $this->repo->matching(['deletedAt' => null]);

        return ListView::fromList(
            array_map(
                static fn(User $user) => UserView::fromUser($user),
                $users,
            )
        );
    }
}
