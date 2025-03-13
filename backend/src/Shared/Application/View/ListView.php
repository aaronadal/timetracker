<?php

namespace Core\Shared\Application\View;

/** @template T of ViewInterface */
final class ListView implements ViewInterface
{
    /**
     * @template L of ViewInterface
     *
     * @param list<L> $list
     *
     * @return self<L>
     */
    public static function fromList(array $list): self
    {
        return new self($list);
    }

    /** @param list<T> $items */
    private function __construct(
        public readonly array $items,
    ) {
    }

    public function serialize(): array
    {
        return array_map(
            static fn(ViewInterface $view) => $view->serialize(),
            $this->items,
        );
    }
}
