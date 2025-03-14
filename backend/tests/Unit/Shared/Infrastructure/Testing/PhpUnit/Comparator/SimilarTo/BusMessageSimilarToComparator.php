<?php

namespace Test\Unit\Shared\Infrastructure\Testing\PhpUnit\Comparator\SimilarTo;

use Core\Shared\Domain\Bus\MessageInterface;
use Core\Shared\Domain\Entity\ValueObject;
use SebastianBergmann\Comparator\ArrayComparator;
use SebastianBergmann\Comparator\Factory;

final class BusMessageSimilarToComparator extends AbstractSimilarToComparator
{
    private readonly ArrayComparator $arrayComparator;

    public function __construct(Factory $factory)
    {
        parent::__construct();
        parent::setFactory($factory);

        $this->arrayComparator = new ArrayComparator();
        $this->arrayComparator->setFactory(Factory::getInstance());
    }

    public function accepts(mixed $expected, mixed $actual): bool
    {
        return $expected instanceof MessageInterface;
    }

    public function assertEquals(
        mixed $expected,
        mixed $actual,
        mixed $delta = 0.0,
        mixed $canonicalize = false,
        mixed $ignoreCase = false,
    ): void
    {
        /** @var MessageInterface $expected */

        if (!$actual instanceof MessageInterface || !is_a($actual, get_class($expected))) {
            throw $this->failure($expected, $actual, 'Failed asserting is an instance of ' . get_class($expected));
        }

        $this->arrayComparator->assertEquals(
            $this->messageToArray($expected),
            $this->messageToArray($actual),
            $delta,
            $canonicalize,
            $ignoreCase,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function messageToArray(MessageInterface $message): array
    {
        $class = new \ReflectionClass($message);
        $props = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        /** @var array<string, mixed> $payload */
        $payload = [];
        foreach ($props as $prop) {
            $name = $prop->getName();

            /** @var mixed $value */
            $value = $prop->getValue($message);
            if($value instanceof ValueObject) {
                /** @var mixed $value */
                $value = $value->value();
            }

            /** @psalm-suppress MixedAssignment */
            $payload[$name] = $value;
        }

        return $payload;
    }
}
