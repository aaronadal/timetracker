<?php

namespace Core\Shared\Domain;

use Core\Shared\Domain\Exception\InvalidValue;

final class PrimitiveExtractor
{
    /** @param array<array-key, mixed> $data */
    public function __construct(
        private readonly array $data,
    ) {
    }

    /** @return non-empty-string */
    public function nonEmptyString(string $key): string
    {
        /** @var mixed $value */
        $value = $this->data[$key] ?? null;
        if (!is_string($value) || $value === '') {
            throw InvalidValue::forExpectedType("$value", 'non-empty-string');
        }

        return $value;
    }
}
