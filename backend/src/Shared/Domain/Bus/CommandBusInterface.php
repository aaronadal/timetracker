<?php

namespace Core\Shared\Domain\Bus;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
