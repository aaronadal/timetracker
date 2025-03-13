<?php

namespace Test\Mother;

final class StringMother
{
    public static function name(): string
    {
        return FakerCreator::get()->name();
    }
}
