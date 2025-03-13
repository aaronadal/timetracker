<?php

namespace Test\Mother;

final class DateTimeMother
{
    public static function between(string $min, string $max): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable(FakerCreator::get()->dateTimeBetween($min, $max));
    }
}
