<?php

namespace App;

use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\OkApiResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('', methods: ['GET'])]
class Health {
    public function __invoke(): ApiResponse
    {
        return new OkApiResponse([
            'ready' => true,
        ]);
    }
}
