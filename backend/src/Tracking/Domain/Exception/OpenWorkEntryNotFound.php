<?php

namespace Core\Tracking\Domain\Exception;

use Core\Shared\Domain\Exception\DomainException;
use Core\Tracking\Domain\Entity\WorkEntryUserId;

final class OpenWorkEntryNotFound extends DomainException
{
    public static function forUser(WorkEntryUserId $userId): self
    {
        return new self(
            "No open work entry could be found for the user <{$userId->value()}>",
        );
    }

    protected static function statusCode(): int
    {
        return 409;
    }
}
