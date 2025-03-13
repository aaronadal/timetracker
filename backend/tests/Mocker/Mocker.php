<?php

namespace Test\Mocker;

use Mockery\MockInterface;

/** @template T of object */
abstract class Mocker
{
    /** @var (T&MockInterface)|null */
    private ?MockInterface $mock = null;

    /** @return class-string<T> */
    abstract public function class(): string;

    /** @return T&MockInterface */
    public function mock(): MockInterface
    {
        if (null === $this->mock) {
            /** @var T&MockInterface $mock */
            $mock = self::createMock($this->class());

            $this->mock = $mock;
        }

        return $this->mock;
    }

    /**
     * @template C
     *
     * @param class-string<C> $classname
     *
     * @return C&MockInterface
     */
    protected static function createMock(string $classname): MockInterface
    {
        /** @var C&MockInterface $mock */
        $mock = \Mockery::mock($classname);

        return $mock;
    }
}
