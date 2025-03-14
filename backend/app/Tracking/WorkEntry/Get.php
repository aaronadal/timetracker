<?php

namespace App\Tracking\WorkEntry;

use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\ViewApiResponse;
use Core\Tracking\Application\Query\WorkEntryByUserAndIdQuery;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracking/{user}/work-entries/{id}', methods: ['GET'])]
final class Get
{
    public function __invoke(
        string $user,
        string $id,
        QueryBusInterface $queryBus,
    ): ApiResponse {
        $entry = $queryBus->ask(new WorkEntryByUserAndIdQuery($id, $user));

        return new ViewApiResponse($entry);
    }
}
