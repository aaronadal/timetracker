<?php

namespace Test\Mother;

use Core\Shared\Domain\TimestampProvider;

final class TimestampMother
{
    public static function lastFewMinutes(): int
    {
        return DateTimeMother::between('-10 minutes', "-1 minute")->getTimestamp();
    }

    public static function lastYear(): int
    {
        $now = TimestampProvider::now();

        return DateTimeMother::between('-365 days', "@$now")->getTimestamp();
    }
}
