<?php

namespace App\Tracking\WorkEntry;

use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\ViewApiResponse;
use Core\Tracking\Application\Query\AllWorkEntriesByUserQuery;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracking/{user}/work-entries', methods: ['GET'])]
final class ListAll
{
    public function __invoke(
        string $user,
        QueryBusInterface $queryBus,
    ): ApiResponse {
        $entries = $queryBus->ask(new AllWorkEntriesByUserQuery($user));

        return new ViewApiResponse($entries);
    }
}
