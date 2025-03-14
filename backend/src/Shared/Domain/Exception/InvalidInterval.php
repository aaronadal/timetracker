<?php

namespace Core\Shared\Domain\Exception;

use Core\Tracking\Domain\Entity\WorkEntryUserId;

final class InvalidInterval extends DomainException
{
    public static function forEndBeforeStart(int $start, int $end): self
    {
        return new self(
            "The end <$end> cannot be before the start <$start>",
        );
    }

    protected static function statusCode(): int
    {
        return 400;
    }
}
