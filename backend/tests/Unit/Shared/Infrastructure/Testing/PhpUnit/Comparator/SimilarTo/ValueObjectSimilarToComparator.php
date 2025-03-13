<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo;

use Core\Shared\Domain\Entity\ValueObject;

final class ValueObjectSimilarToComparator extends AbstractSimilarToComparator
{
    public function accepts(mixed $expected, mixed $actual): bool
    {
        return $expected instanceof ValueObject;
    }

    public function assertEquals(
        mixed $expected,
        mixed $actual,
        mixed $delta = 0.0,
        mixed $canonicalize = false,
        mixed $ignoreCase = false,
    ): void
    {
        /** @var ValueObject $expected */

        if(!$actual instanceof ValueObject) {
            throw $this->failure($expected, $actual, 'Failed asserting a is isntance of ValueObject');
        }

        if (!$expected->equals($actual)) {
            throw $this->failure($expected, $actual, 'Failed asserting a ValueObject is similar to another');
        }
    }
}
