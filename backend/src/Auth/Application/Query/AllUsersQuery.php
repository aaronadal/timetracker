<?php

namespace Core\Auth\Application\Query;

use Core\Auth\Application\View\UserView;
use Core\Shared\Application\View\ListView;
use Core\Shared\Domain\Bus\QueryInterface;

/** @implements QueryInterface<ListView<UserView>> */
final class AllUsersQuery implements QueryInterface
{
}
