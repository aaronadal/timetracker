<?php

namespace Test\Mother;


abstract class IntegerMother
{
    public static function between(int $min, int $max): int
    {
        return intval(FakerCreator::get()->randomFloat(0, $min, $max));
    }
}
