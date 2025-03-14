<?php

namespace App\Auth;

use Core\Auth\Application\Query\AllUsersQuery;
use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\ViewApiResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth/users', methods: ['GET'])]
final class ListAll
{
    public function __invoke(
        QueryBusInterface $queryBus,
    ): ApiResponse {
        $users = $queryBus->ask(new AllUsersQuery());

        return new ViewApiResponse($users);
    }
}
