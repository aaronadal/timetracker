<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo;

final class CompositeArraySimilarToComparator extends AbstractSimilarToComparator
{
    public function __construct(
        private readonly AbstractSimilarToComparator $inner,
    )
    {
        parent::__construct();
    }

    public function accepts(mixed $expected, mixed $actual): bool
    {
        if (!is_array($expected)) {
            return false;
        }

        /** @var mixed[] $expected */
        /** @var mixed $item */
        foreach ($expected as $item) {
            if (!$this->inner->accepts($item, $actual)) {
                return false;
            }
        }

        return true;
    }

    public function assertEquals(
        mixed $expected,
        mixed $actual,
        mixed $delta = 0.0,
        mixed $canonicalize = false,
        mixed $ignoreCase = false,
    ): void
    {
        /** @var mixed[] $expected */
        
        if (!is_array($actual)) {
            throw $this->failure($expected, $actual, 'Failed asserting actual is an array');
        }

        /** @var mixed[] $actual */

        if (count($expected) !== count($actual)) {
            throw $this->failure($expected, $actual, 'Failed asserting actual has the expected number of elements');
        }

        $expected = array_values($expected);
        $actual = array_values($actual);

        /** @var mixed $expectedItem */
        foreach ($expected as $key => $expectedItem) {
            /** @var mixed $actualItem */
            $actualItem = $actual[$key];

            $this->inner->assertEquals($expectedItem, $actualItem);
        }
    }
}
