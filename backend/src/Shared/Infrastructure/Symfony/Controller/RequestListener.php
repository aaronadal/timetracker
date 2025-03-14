<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener('kernel.request', priority: 64)]
class RequestListener
{
    use CorsTrait;

    public function __invoke(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        if ('OPTIONS' === $request->getMethod()) {
            $response = new Response();
            $this->setCorsHeaders($response);

            $event->setResponse($response);
        }
    }
}
