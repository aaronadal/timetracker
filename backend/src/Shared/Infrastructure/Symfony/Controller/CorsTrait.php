<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Symfony\Component\HttpFoundation\Response;

trait CorsTrait
{
    protected function setCorsHeaders(Response $response): void
    {
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Authorization, Content-Type');
        $response->headers->set('Access-Control-Expose-Headers', 'Content-Disposition');
    }
}
