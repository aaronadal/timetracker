<?php

namespace App\Auth;

use Core\Auth\Application\Command\SignUpCommand;
use Core\Auth\Domain\Entity\UserId;
use Core\Auth\Domain\Entity\UserName;
use Core\Shared\Domain\Bus\CommandBusInterface;
use Core\Shared\Domain\PrimitiveExtractor;
use Core\Shared\Infrastructure\Symfony\Controller\ApiResponse;
use Core\Shared\Infrastructure\Symfony\Controller\CreatedApiResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth/sign-up', methods: ['POST'])]
final class SignUp
{
    public function __invoke(
        PrimitiveExtractor $body,
        CommandBusInterface $commandBus,
    ): ApiResponse {
        $id = UserId::random();
        $name = UserName::fromValue($body->nonEmptyString('name'));

        $commandBus->dispatch(
            new SignUpCommand($id, $name),
        );

        return new CreatedApiResponse();
    }
}
