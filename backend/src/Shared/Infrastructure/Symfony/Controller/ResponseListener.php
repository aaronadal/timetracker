<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

#[AsEventListener('kernel.response')]
class ResponseListener
{
    use CorsTrait;

    public function __invoke(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $response = $event->getResponse();
        $this->setCorsHeaders($response);
    }
}
