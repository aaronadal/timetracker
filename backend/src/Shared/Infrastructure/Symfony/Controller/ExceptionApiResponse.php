<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Core\Shared\Domain\Exception\DomainException;

final class ExceptionApiResponse extends ApiResponse
{
    public function __construct(\Throwable $throwable, bool $debug)
    {
        $code = self::HTTP_INTERNAL_SERVER_ERROR;
        if($throwable instanceof DomainException) {
            $code = $throwable->getStatusCode();
        }

        parent::__construct($this->data($throwable, $debug), $code);
    }

    /** @return array<array-key, mixed> */
    private function data(\Throwable $throwable, bool $debug): array
    {
        $message = 'An unexpected error occurred';
        if($throwable instanceof DomainException) {
            $message = $throwable->getMessage();
        }

        /** @var array<array-key, mixed> $data */
        $data = [
            'message' => $message,
        ];

        if($debug) {
            $data['debug'] = [
                'message' => $throwable->getMessage(),
                'trace' => $throwable->getTrace(),
            ];
        }

        return $data;
    }
}
