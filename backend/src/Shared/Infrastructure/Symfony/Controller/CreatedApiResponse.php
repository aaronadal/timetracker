<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

final class CreatedApiResponse extends ApiResponse
{
    public function __construct()
    {
        parent::__construct(null, self::HTTP_CREATED);
    }
}
