<?php

namespace Core\Shared\Domain;

final class TimestampProvider
{
    private static ?int $MOCK = null;

    public static function now(): int
    {
        if(self::$MOCK !== null) {
            return self::$MOCK;
        }

        return time();
    }

    public static function mock(int $timestamp): void
    {
        self::$MOCK = $timestamp;
    }

    public static function clear(): void
    {
        self::$MOCK = null;
    }
}
