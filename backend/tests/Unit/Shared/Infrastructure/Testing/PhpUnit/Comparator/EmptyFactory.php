<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator;

use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\Factory;
use SebastianBergmann\Comparator\RuntimeException;

final class EmptyFactory extends Factory
{
    public function __construct()
    {
        // Do not call parent constructor as it is initializing default comparators, and we do not want to.
    }

    public function getComparatorFor(mixed $expected, mixed $actual): Comparator
    {
        try {
            return parent::getComparatorFor($expected, $actual);
        } catch (RuntimeException $e) {
            throw new RuntimeException('Failed to create Comparator for ' . get_debug_type($expected));
        }
    }
}
