<?php

namespace Test\Mother;

abstract class MultipleMother
{
    /**
     * @template T of mixed
     *
     * @param callable(): T $generator
     *
     * @return list<T>
     */
    public static function random(callable $generator): array
    {
        return self::between($generator, 0, 10);
    }

    /**
     * @template T of mixed
     *
     * @param callable(): T $generator
     *
     * @return list<T>
     */
    public static function between(callable $generator, int $lowerLimit, int $upperLimit): array
    {
        return self::exactly($generator, IntegerMother::between($lowerLimit, $upperLimit));
    }

    /**
     * @template T of mixed
     *
     * @param callable(): T $generator
     *
     * @return list<T>
     */
    public static function exactly(callable $generator, int $count): array
    {
        return array_map(
            $generator,
            array_fill(0, $count, null),
        );
    }
}
