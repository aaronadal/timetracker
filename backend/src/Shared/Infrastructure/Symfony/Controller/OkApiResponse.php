<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

final class OkApiResponse extends ApiResponse
{
    /** @param array<mixed> $data */
    public function __construct(array $data = [])
    {
        parent::__construct($data, self::HTTP_OK);
    }
}
