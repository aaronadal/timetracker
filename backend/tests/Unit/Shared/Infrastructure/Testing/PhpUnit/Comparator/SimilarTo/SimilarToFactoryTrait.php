<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo;

use SebastianBergmann\Comparator\Factory;
use Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\EmptyFactory;

trait SimilarToFactoryTrait
{
    private function buildSimilarToFactory(): Factory
    {
        // Last comparators take preference over former ones.
        $factory = new EmptyFactory();

        $valueObjectComparator = new ValueObjectSimilarToComparator();
        $factory->register($valueObjectComparator);
        $factory->register(new CompositeArraySimilarToComparator($valueObjectComparator));

        $aggregateRootComparator = new AggregateRootSimilarToComparator($factory);
        $factory->register($aggregateRootComparator);
        $factory->register(new CompositeArraySimilarToComparator($aggregateRootComparator));

        return $factory;
    }
}
