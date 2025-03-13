<?php

namespace Core\Shared\Infrastructure\Bus\Messenger;

use Core\Shared\Application\View\ViewInterface;
use Core\Shared\Domain\Bus\QueryBusInterface;
use Core\Shared\Domain\Bus\QueryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessengerQueryBus implements QueryBusInterface
{
    private readonly MessageBusInterface $bus;

    public function __construct(
        MessageBusInterface $queryBus,
    ) {
        $this->bus = $queryBus;
    }

    /**
     * @template T of ViewInterface
     * @param QueryInterface<T> $query
     *
     * @return T
     */
    public function ask(QueryInterface $query): ViewInterface
    {
        try {
            $envelope = $this->bus->dispatch($query);

            $stamp = $envelope->last(HandledStamp::class);
            if (!$stamp) {
                throw new \RuntimeException('No HandledStamp was found in the envelope');
            }

            /** @var T $result */
            $result = $stamp->getResult();

            return $result;
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?: $exception;
        }
    }
}
