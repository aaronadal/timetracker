<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ApiResponse extends JsonResponse
{
    /** @param array<array-key, mixed>|null $data */
    public function __construct(?array $data = null, int $status = 200)
    {
        $data = [
            'status' => $status,
            'success' => $status >= 200 && $status < 300,
            'timestamp' => time(),
            'payload' => $data,
        ];

        parent::__construct($data, $status);
    }
}
