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
            throw InvalidValue::forExpectedType("$key $value", 'non-empty-string');
        }

        return $value;
    }

    /**
     * @return ($nullable is true ? int|null : int)
     */
    public function positiveInteger(string $key, bool $nullable = false): ?int
    {
        /** @var mixed $value */
        $value = $this->data[$key] ?? null;

        if($value === null) {
            if(!$nullable) {
                throw InvalidValue::forExpectedType("$key $value", 'integer');
            }
        }
        else if (!is_int($value) || $value < 1) {
            throw InvalidValue::forExpectedType("$key $value", 'integer');
        }

        return $value;
    }
}
