<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ApiResponse extends JsonResponse
{
    /** @param array<mixed>|null $data */
    public function __construct(?array $data = null, int $status = 200)
    {
        $data = [
            'success' => $status >= 200 && $status < 300,
            'timestamp' => time(),
            'payload' => $data,
        ];

        parent::__construct($data, $status);
    }
}
