<?php

namespace Core\Shared\Domain\Bus;

interface EventBusInterface
{
    public function publish(EventInterface $event): void;
}
