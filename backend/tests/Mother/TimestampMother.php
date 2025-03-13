<?php

namespace Test\Mother;

final class TimestampMother
{
    public static function lastYear(): int
    {
        return DateTimeMother::between('-365 days', '-1 minute')->getTimestamp();
    }
}
