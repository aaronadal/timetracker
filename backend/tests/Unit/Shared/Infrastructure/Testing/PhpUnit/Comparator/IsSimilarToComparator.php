<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator;

use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\Factory;
use Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo\SimilarTo;
use Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo\SimilarToFactoryTrait;

final class IsSimilarToComparator extends Comparator
{
    use SimilarToFactoryTrait;

    private readonly Factory $similarToFactory;

    public function __construct()
    {
        parent::__construct();

        $this->factory = Factory::getInstance();
        $this->similarToFactory = $this->buildSimilarToFactory();
    }

    public function accepts(mixed $expected, mixed $actual): bool
    {
        return $expected instanceof SimilarTo;
    }

    public function assertEquals(
        mixed $expected,
        mixed $actual,
        mixed $delta = 0.0,
        mixed $canonicalize = false,
        mixed $ignoreCase = false,
    ): void {
        /** @var SimilarTo $expected */

        if ($expected->value === $actual) {
            return;
        }

        $comparator = $this->similarToFactory->getComparatorFor($expected->value, $actual);

        $comparator->assertEquals($expected->value, $actual, $delta, $canonicalize, $ignoreCase);
    }
}
