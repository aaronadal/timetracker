<?php

namespace Test\Unit\Auth\Application\Command;

use Core\Auth\Application\Command\SignUpHandler;
use Core\Shared\Domain\Entity\CreatedAt;
use Core\Shared\Domain\Entity\UpdatedAt;
use Core\Shared\Domain\Exception\InvalidValue;
use Core\Shared\Domain\TimestampProvider;
use Test\Mocker\Auth\Domain\Persistence\UserRepositoryMocker;
use Test\Mother\Auth\Application\Command\SignUpCommandMother;
use Test\Mother\Auth\Domain\Entity\UserMother;
use Test\Mother\TimestampMother;
use Test\Unit\UnitTest;

final class SignUpHandlerTest extends UnitTest
{
    private int $now;
    private UserRepositoryMocker $repo;
    private SignUpHandler $handler;

    protected function setUp(): void
    {
        $this->now = TimestampMother::lastFewMinutes();
        TimestampProvider::mock($this->now);

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

        $this->expectExceptionObject(InvalidValue::forDuplicatedValue($command->name->value()));
        ($this->handler)($command);
    }

    public function testSignsUpSuccessfully(): void
    {
        $command = SignUpCommandMother::create();
        $user = UserMother::createNotDeleted(
            $command->id,
            $command->name,
            CreatedAt::fromValue($this->now),
            UpdatedAt::fromValue($this->now),
        );

        $this->repo->matching(['name' => $command->name->value()], []);
        $this->repo->save($user);

        ($this->handler)($command);
    }
}
