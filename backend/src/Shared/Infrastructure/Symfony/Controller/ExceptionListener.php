<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener('kernel.exception')]
class ExceptionListener
{
    use CorsTrait;

    public function __construct(
        private readonly bool $debug,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $response = new ExceptionApiResponse($event->getThrowable(), $this->debug);
        $this->setCorsHeaders($response);

        $event->setResponse($response);
    }
}
