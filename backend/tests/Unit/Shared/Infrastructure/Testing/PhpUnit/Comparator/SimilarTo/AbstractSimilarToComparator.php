<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo;

use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;
use Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\EmptyFactory;

abstract class AbstractSimilarToComparator extends Comparator
{
    public function __construct()
    {
        parent::__construct();
        
        $this->factory = new EmptyFactory();
    }

    protected function failure(mixed $expected, mixed $actual, string $message): ComparisonFailure
    {
        return new ComparisonFailure(
            $expected,
            $actual,
            $this->exporter->export($expected),
            $this->exporter->export($actual),
            false,
            $message,
        );
    }
}
