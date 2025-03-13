<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo;

final class SimilarTo
{
    public function __construct(
        public readonly mixed $value,
    ) {
    }
}
