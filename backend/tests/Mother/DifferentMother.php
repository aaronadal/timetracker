<?php

namespace Test\Mother;

use Core\Shared\Domain\Entity\ValueObject;

abstract class DifferentMother
{
    /**
     * @template T of mixed
     *
     * @param T $reference
     * @param callable(): T $generator
     *
     * @return T
     */
    public static function create(
        mixed    $reference,
        callable $generator,
    ): mixed
    {
        do {
            $different = $generator();
        } while (self::equals($different, $reference));

        return $different;
    }

    /**
     * @template T of mixed
     *
     * @param T $different
     * @param T $reference
     */
    private static function equals(mixed $different, mixed $reference): bool
    {
        if($different instanceof ValueObject && $reference instanceof ValueObject) {
            return $different->equals($reference);
        }

        return $different === $reference;
    }
}
