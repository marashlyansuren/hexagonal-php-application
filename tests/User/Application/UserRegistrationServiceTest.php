<?php

namespace App\Tests\User\Application;

use App\User\Application\Exception\UserException;
use App\User\Application\Port\In\UserRegisterCommand;
use App\User\Application\Port\Out\LoadUserPort;
use App\User\Application\Port\Out\UpdateUserStatePort;
use App\User\Domain\Event\UserRegisteredEventFactory;
use App\User\Domain\UserFactory;
use App\User\Application\UserRegistrationService;
use App\User\Domain\User;
use App\User\Domain\UserType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

class UserRegistrationServiceTest extends TestCase
{
    /**
     * @var UserFactory|MockObject
     */
    private $userFactory;

    /**
     * @var UserRegisteredEventFactory|MockObject
     */
    private $userRegisteredEventFactory;

    /**
     * @var LoadUserPort|MockObject
     */
    private $loadUserPort;

    /**
     * @var UpdateUserStatePort|MockObject
     */
    private $updateUserStatePort;

    /**
     * @var PsrEventDispatcherInterface|MockObject
     */
    private $eventDispatcher;

    /**
     * @var UserRegistrationService
     */
    private $userRegistrationService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userFactory = $this->createMock(UserFactory::class);
        $this->userRegisteredEventFactory = $this->createMock(UserRegisteredEventFactory::class);
        $this->loadUserPort = $this->createMock(LoadUserPort::class);
        $this->updateUserStatePort = $this->createMock(UpdateUserStatePort::class);
        $this->eventDispatcher = $this->createMock(PsrEventDispatcherInterface::class);


        $this->userRegistrationService = new UserRegistrationService(
            $this->userFactory,
            $this->userRegisteredEventFactory,
            $this->loadUserPort,
            $this->updateUserStatePort,
            $this->eventDispatcher
        );
    }

    /**
     * @return void
     * @throws \App\User\Application\Exception\UserException
     */
    public function testSuccessfulRegister(): void
    {
        $user = $this->createMock(User::class);
        $userRegisterCommand = new UserRegisterCommand(
            "some-email",
            "some-password"
        );

        $this->loadUserPort->method("findByEmail")->with($userRegisterCommand->getEmail())->willReturn(null);
        $this->userFactory->method("createFromUserRegisterCommand")->with($userRegisterCommand)->willReturn($user);

        $this->updateUserStatePort->expects($this->once())->method("save")->with($user);
        $this->assertSame($user, $this->userRegistrationService->register($userRegisterCommand));
    }

    /**
     * @return void
     * @throws \App\User\Application\Exception\UserException
     */
    public function testRegisterWhenUserExists(): void
    {
        $user = $this->createMock(User::class);
        $userRegisterCommand = new UserRegisterCommand(
            "some-email",
            "some-password"
        );

        $this->loadUserPort->method("findByEmail")->with($userRegisterCommand->getEmail())->willReturn($user);

        $this->updateUserStatePort->expects($this->never())->method("save");
        $this->expectException(UserException::class);

        $this->userRegistrationService->register($userRegisterCommand);
    }
}