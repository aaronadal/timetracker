<?php

namespace Core\Auth\Application\Command;

use Core\Auth\Domain\Entity\User;
use Core\Auth\Domain\Entity\UserName;
use Core\Auth\Domain\Persistence\UserRepositoryInterface;
use Core\Shared\Domain\Bus\CommandHandlerInterface;
use Core\Shared\Domain\Exception\InvalidValue;

final class SignUpHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repo,
    )
    {
    }

    public function __invoke(SignUpCommand $command): void
    {
        $this->guardUserNameAvailable($command->name);

        $user = User::create(
            $command->id,
            $command->name,
        );

        $this->repo->save($user);

        // TODO: Publish Domain Events.
    }

    private function guardUserNameAvailable(UserName $name): void
    {
        $result = $this->repo->matching([
            'name' => $name->value(),
        ]);

        if (count($result) > 0) {
            throw InvalidValue::forDuplicatedValue($name->value());
        }
    }
}
