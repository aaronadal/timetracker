<?php

namespace Test\Mother;

use Faker\Factory;
use Faker\Generator;

final class FakerCreator
{
    private static ?Generator $faker = null;

    public static function get(): Generator
    {
        return self::$faker ??= Factory::create();
    }
}
