<?php

namespace Core\Shared\Domain\Bus;

use Core\Shared\Application\View\ViewInterface;

interface QueryBusInterface
{
    /**
     * @template T of ViewInterface
     * @param QueryInterface<T> $query
     *
     * @return T
     */
    public function ask(QueryInterface $query): ViewInterface;
}
