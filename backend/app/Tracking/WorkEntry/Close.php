<?php

namespace App\Tracking\WorkEntry;

use Core\Shared\Domain\Bus\CommandBusInterface;
use Core\Shared\Domain\PrimitiveExtractor;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\NoContentApiResponse;
use Core\Tracking\Application\Command\CloseWorkEntryCommand;
use Core\Tracking\Domain\Entity\WorkEntryEnd;
use Core\Tracking\Domain\Entity\WorkEntryUserId;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracking/{user}/work-entries/close', methods: ['POST'])]
final class Close
{
    public function __invoke(
        string $user,
        PrimitiveExtractor $body,
        CommandBusInterface $commandBus,
    ): ApiResponse
    {
        $commandBus->dispatch(
            new CloseWorkEntryCommand(
                user: WorkEntryUserId::fromValue($user),
                end: WorkEntryEnd::fromValue($body->positiveInteger('end')),
            ),
        );

        return new NoContentApiResponse();
    }
}
