<?php

namespace Core\Shared\Application\View;

interface ViewInterface
{
    /** @return array<array-key, mixed> */
    public function serialize(): array;
}
