<?php

namespace App\Tracking\WorkEntry;

use Core\Shared\Domain\Bus\CommandBusInterface;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\NoContentApiResponse;
use Core\Tracking\Application\Command\DeleteWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracking/{user}/work-entries/{id}', methods: ['DELETE'])]
final class Delete
{
    public function __invoke(
        string $user,
        string $id,
        CommandBusInterface $commandBus,
    ): ApiResponse
    {
        $commandBus->dispatch(
            new DeleteWorkEntryCommand(
                id: WorkEntryId::fromValue($id),
                user: WorkEntryUserId::fromValue($user),
            ),
        );

        return new NoContentApiResponse();
    }
}
