<?php

namespace Core\Shared\Application\View;

use function Symfony\Component\String\u;

trait PublicPropertiesViewTrait
{
    /** @return array<array-key, mixed> */
    public function serialize(): array
    {
        $class = new \ReflectionClass(static::class);
        $props = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        /** @var array<string, mixed> $payload */
        $payload = [];
        foreach ($props as $prop) {
            $name = u($prop->getName())->camel()->toString();

            /** @psalm-suppress MixedAssignment */
            $payload[$name] = $prop->getValue($this);
        }

        return $payload;
    }
}
