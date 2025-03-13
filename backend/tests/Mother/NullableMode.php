<?php

namespace Test\Mother;

enum NullableMode
{
    case MAYBE_NULL;
    case NOT_NULL;
    case VALUE;
}
