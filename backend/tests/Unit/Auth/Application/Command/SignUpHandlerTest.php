<?php

namespace Test\Unit\Auth\Application\Command;

use Core\Auth\Application\Command\SignUpHandler;
use Core\Auth\Domain\Entity\UserCreatedAt;
use Core\Auth\Domain\Entity\UserUpdatedAt;
use Core\Shared\Domain\Exception\InvalidValueException;
use Core\Shared\Domain\TimestampProvider;
use Test\Mocker\Auth\Domain\Persistence\UserRepositoryMocker;
use Test\Mother\Auth\Application\Command\SignUpCommandMother;
use Test\Mother\Auth\Domain\Entity\UserMother;
use Test\Mother\TimestampMother;
use Test\Unit\UnitTest;

final class SignUpHandlerTest extends UnitTest
{
    private UserRepositoryMocker $repo;
    private SignUpHandler $handler;

    protected function setUp(): void
    {
        $this->repo = new UserRepositoryMocker();
        $this->handler = new SignUpHandler(
            repo: $this->repo->mock(),
        );
    }

    protected function tearDown(): void
    {
        TimestampProvider::clear();
    }

    public function testFailsIfUserNameAlreadyExists(): void
    {
        $command = SignUpCommandMother::create();
        $user = UserMother::createNotDeleted();

        $this->repo->matching(['name' => $command->name->value()], [$user]);
        $this->repo->notSave();

        $this->expectExceptionObject(InvalidValueException::forDuplicatedValue($command->name->value()));
        ($this->handler)($command);
    }

    public function testSignsUpSuccessfully(): void
    {
        $now = TimestampMother::lastYear();
        TimestampProvider::mock($now);

        $command = SignUpCommandMother::create();
        $user = UserMother::createNotDeleted(
            $command->id,
            $command->name,
            UserCreatedAt::fromValue($now),
            UserUpdatedAt::fromValue($now),
        );

        $this->repo->matching(['name' => $command->name->value()], []);
        $this->repo->save($user);

        ($this->handler)($command);
    }
}
