<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

final class NoContentApiResponse extends ApiResponse
{
    public function __construct()
    {
        parent::__construct(null, self::HTTP_NO_CONTENT);
    }
}
