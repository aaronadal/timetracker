<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Core\Shared\Domain\Entity\UuidValueObject;

final class CreatedApiResponse extends ApiResponse
{
    public function __construct(UuidValueObject $id)
    {
        parent::__construct(['id' => $id->value()], self::HTTP_CREATED);
    }
}
