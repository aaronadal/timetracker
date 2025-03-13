<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo;

use Core\Shared\Domain\Entity\AggregateRoot;
use SebastianBergmann\Comparator\Factory;

final class AggregateRootSimilarToComparator extends AbstractSimilarToComparator
{
    private const EXCLUDED_METHODS = [
    ];

    public function __construct(Factory $factory)
    {
        parent::__construct();
        parent::setFactory($factory);
    }

    public function accepts(mixed $expected, mixed $actual): bool
    {
        return $expected instanceof AggregateRoot;
    }

    public function assertEquals(
        mixed $expected,
        mixed $actual,
        mixed $delta = 0.0,
        mixed $canonicalize = false,
        mixed $ignoreCase = false,
    ): void
    {
        /** @var AggregateRoot $expected */

        if (!$actual instanceof AggregateRoot) {
            throw $this->failure($expected, $actual, 'Failed asserting is an instance of AggregateRoot');
        }

        $reflection = new \ReflectionClass($expected);
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if ($method->isStatic()) {
                continue;
            }

            if (in_array($method->getName(), self::EXCLUDED_METHODS, true)) {
                continue;
            }

            $return = $method->getReturnType();

            $name = 'void';
            if ($return instanceof \ReflectionNamedType) {
                $name = $return->getName();
            }

            if ($return instanceof \ReflectionNamedType && $name !== 'void') {
                /** @var mixed $expectedValue */
                $expectedValue = $method->invoke($expected);

                /** @var mixed $actualValue */
                $actualValue = $method->invoke($actual);

                if($actualValue === null && $expectedValue === null) {
                    continue;
                }
                if($actualValue === null || $expectedValue === null) {
                    throw $this->failure($expected, $actual, 'Failed asserting that null is not null');
                }

                if (!$return->isBuiltin()) {
                    $comparator = $this->factory->getComparatorFor($expectedValue, $actualValue);
                    $comparator->assertEquals($expectedValue, $actualValue, $delta, $canonicalize, $ignoreCase);
                } else if ($expectedValue !== $actualValue) {
                    throw $this->failure($expected, $actual, 'Failed asserting that');
                }
            }
        }
    }
}
