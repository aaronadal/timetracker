<?php

namespace Test\Mother;

final class UuidMother
{
    public static function random(): string
    {
        return FakerCreator::get()->uuid();
    }
}
