<?php

namespace Core\Auth\Application\Query;

use Core\Auth\Application\View\UserView;
use Core\Shared\Domain\Bus\QueryInterface;

/** @implements QueryInterface<UserView> */
final class UserByIdQuery implements QueryInterface
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}
