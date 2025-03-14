<?php

namespace Core\Shared\Domain\Bus;

use Core\Shared\Application\View\ViewInterface;

/** @template T of ViewInterface */
interface QueryInterface extends MessageInterface
{
}
