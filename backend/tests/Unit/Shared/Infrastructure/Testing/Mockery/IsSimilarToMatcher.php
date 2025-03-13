<?php

namespace Test\Unit\Shared\Infrastructure\Testing\Mockery;

use Mockery\Matcher\MatcherInterface;
use SebastianBergmann\Comparator\ComparisonFailure;
use Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\IsSimilarToComparator;
use Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo\SimilarTo;

final class IsSimilarToMatcher implements MatcherInterface
{
    public static function fromExpected(mixed $expected): self
    {
        return new self($expected);
    }

    private readonly SimilarTo $expected;
    private readonly IsSimilarToComparator $comparator;

    private function __construct(
        mixed $expected,
    ) {
        $this->expected = new SimilarTo($expected);
        $this->comparator = new IsSimilarToComparator();
    }

    public function __toString(): string
    {
        return 'is similar to';
    }

    public function match(&$actual): bool
    {
        try {
            $this->comparator->assertEquals(
                $this->expected,
                $actual,
            );

            return true;
        }
        catch (ComparisonFailure $e) {
            print($e->getMessage());

            return false;
        }
    }
}
