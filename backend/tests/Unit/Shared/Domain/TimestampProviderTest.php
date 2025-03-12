<?php

namespace Test\Unit\Shared\Domain;

use Core\Shared\Domain\TimestampProvider;
use Test\Unit\UnitTest;

final class TimestampProviderTest extends UnitTest
{
    public function testNative(): void
    {
        self::assertEquals(time(), TimestampProvider::now());
    }

    public function testMock(): void
    {
        $mockValue = time() - 1000;
        TimestampProvider::mock($mockValue);

        self::assertEquals($mockValue, TimestampProvider::now());

        TimestampProvider::clear();
    }

    public function testClear(): void
    {
        $mockValue = time() - 1000;
        TimestampProvider::mock($mockValue);
        TimestampProvider::clear();

        self::assertEquals(time(), TimestampProvider::now());
    }
}
