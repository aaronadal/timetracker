<?php

namespace Test\Mocker\Shared\Domain\Bus;

use Core\Shared\Application\View\ViewInterface;
use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Shared\Domain\Bus\QueryInterface;
use Test\Mocker\Mocker;
use Test\Unit\Shared\Infrastructure\Testing\Mockery\IsSimilarToMatcher;

/** @extends Mocker<QueryBusInterface> */
final class QueryBusMocker extends Mocker
{
    public function class(): string
    {
        return QueryBusInterface::class;
    }

    /**
     * @template T of ViewInterface
     *
     * @param QueryInterface<T> $query
     * @param T $result
     */
    public function ask(QueryInterface $query, ViewInterface $result): void
    {
        $this->mock()
            ->shouldReceive('ask')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($query))
            ->andReturn($result);
    }

    /**
     * @template T of ViewInterface
     *
     * @param QueryInterface<T> $query
     */
    public function askAndFail(QueryInterface $query, \Throwable $throwable): void
    {
        $this->mock()
            ->shouldReceive('ask')
            ->once()
            ->ordered()
            ->with(IsSimilarToMatcher::fromExpected($query))
            ->andThrow($throwable);
    }
}
