<?php

namespace Core\Auth\Application\Query;

use Core\Auth\Application\View\UserView;
use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Persistence\UserRepositoryInterface;
use Core\Shared\Application\View\ViewInterface;
use Core\Shared\Domain\Bus\QueryHandlerInterface;
use Core\Shared\Domain\Exception\EntityNotFound;

final class UserByIdHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repo,
    ) {
    }

    public function __invoke(UserByIdQuery $query): ViewInterface
    {
        $id = UserId::fromValue($query->id);
        $users = $this->repo->matching(['id' => $id->value(), 'deletedAt' => null]);
        if(count($users) === 0) {
            throw EntityNotFound::forClassAndId(User::class, $id);
        }

        return UserView::fromUser($users[0]);
    }
}
