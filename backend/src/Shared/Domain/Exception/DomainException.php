<?php

namespace Core\Shared\Domain\Exception;

abstract class DomainException extends \Exception
{
    protected abstract static function statusCode(): int;

    protected function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, static::statusCode(), $previous);
    }

    public function getStatusCode(): int
    {
        return static::statusCode();
    }
}
