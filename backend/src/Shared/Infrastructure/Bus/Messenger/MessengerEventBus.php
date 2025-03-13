<?php

namespace Core\Shared\Infrastructure\Bus\Messenger;

use Core\Shared\Domain\Bus\EventBusInterface;
use Core\Shared\Domain\Bus\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventBus implements EventBusInterface
{
    private readonly MessageBusInterface $bus;

    public function __construct(
        MessageBusInterface $eventBus,
    )
    {
        $this->bus = $eventBus;
    }

    public function publish(EventInterface $event): void
    {
        $this->bus->dispatch($event);
    }
}
