<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit;

use SebastianBergmann\Comparator\Factory;
use Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\IsSimilarToComparator;

final class Bootstrap
{
    public static function bootstrap(): void
    {
        $factory = Factory::getInstance();

        $factory->register(new IsSimilarToComparator());
    }
}
