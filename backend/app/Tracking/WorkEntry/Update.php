<?php

namespace App\Tracking\WorkEntry;

use Core\Shared\Domain\Bus\CommandBusInterface;
use Core\Shared\Domain\PrimitiveExtractor;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\NoContentApiResponse;
use Core\Tracking\Application\Command\UpdateWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryStart;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracking/{user}/work-entries/{id}', methods: ['PUT'])]
final class Update
{
    public function __invoke(
        string $user,
        string $id,
        PrimitiveExtractor $body,
        CommandBusInterface $commandBus,
    ): ApiResponse
    {
        $commandBus->dispatch(
            new UpdateWorkEntryCommand(
                id: WorkEntryId::fromValue($id),
                user: WorkEntryUserId::fromValue($user),
                start: WorkEntryStart::fromValue($body->positiveInteger('start')),
                end: WorkEntryEnd::fromValueOrNull($body->positiveInteger('end', true)),
            ),
        );

        return new NoContentApiResponse();
    }
}
