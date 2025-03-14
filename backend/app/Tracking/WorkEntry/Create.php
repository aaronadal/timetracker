<?php

namespace App\Tracking\WorkEntry;

use Core\Shared\Domain\Bus\CommandBusInterface;
use Core\Shared\Domain\PrimitiveExtractor;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\CreatedApiResponse;
use Core\Tracking\Application\Command\CreateWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryStart;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracking/{user}/work-entries', methods: ['POST'])]
final class Create
{
    public function __invoke(
        string $user,
        PrimitiveExtractor $body,
        CommandBusInterface $commandBus,
    ): ApiResponse
    {
        $id = WorkEntryId::random();

        $commandBus->dispatch(
            new CreateWorkEntryCommand(
                id: $id,
                user: WorkEntryUserId::fromValue($user),
                start: WorkEntryStart::fromValue($body->positiveInteger('start')),
                end: WorkEntryEnd::fromValueOrNull($body->positiveInteger('end', true)),
            ),
        );

        return new CreatedApiResponse($id);
    }
}
