<?php

namespace App\Tracking\WorkEntry;

use Core\Shared\Domain\Bus\CommandBusInterface;
use Core\Shared\Domain\PrimitiveExtractor;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\CreatedApiResponse;
use Core\Tracking\Application\Command\OpenWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryId;
use Core\Tracking\Domain\Entity\WorkEntryStart;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracking/{user}/work-entries/open', methods: ['POST'])]
final class Open
{
    public function __invoke(
        string $user,
        PrimitiveExtractor $body,
        CommandBusInterface $commandBus,
    ): ApiResponse
    {
        $id = WorkEntryId::random();

        $commandBus->dispatch(
            new OpenWorkEntryCommand(
                id: $id,
                user: WorkEntryUserId::fromValue($user),
                start: WorkEntryStart::fromValue($body->positiveInteger('start')),
            ),
        );

        return new CreatedApiResponse($id);
    }
}
