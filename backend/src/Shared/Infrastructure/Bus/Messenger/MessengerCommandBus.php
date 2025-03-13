<?php

namespace Core\Shared\Infrastructure\Bus\Messenger;

use Core\Shared\Domain\Bus\CommandBusInterface;
use Core\Shared\Domain\Bus\CommandInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBusInterface
{
    private readonly MessageBusInterface $bus;

    public function __construct(
        MessageBusInterface $commandBus,
    )
    {
        $this->bus = $commandBus;
    }

    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->bus->dispatch($command);
        }
        catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?: $exception;
        }
    }
}
