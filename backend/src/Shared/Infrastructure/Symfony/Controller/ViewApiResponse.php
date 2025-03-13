<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;

use Core\Shared\Application\View\ViewInterface;

final class ViewApiResponse extends ApiResponse
{
    public function __construct(ViewInterface $view)
    {
        parent::__construct($view->serialize(), self::HTTP_OK);
    }
}
