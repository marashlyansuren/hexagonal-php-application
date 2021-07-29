<?php

namespace App\Tests\User\Domain;

use App\Common\DateTimeGeneratorInterface;
use App\Common\PasswordEncoderInterface;
use App\Common\UuidGeneratorInterface;
use App\Tests\ApplicationTestCase;
use App\User\Application\Port\In\UserRegisterCommand;
use App\User\Domain\UserFactory;
use App\User\Domain\UserType;
use PHPUnit\Framework\MockObject\MockObject;

class UserFactoryTest extends ApplicationTestCase
{
    /**
     * @var UuidGeneratorInterface|MockObject
     */
    private $uuidGenerator;

    /**
     * @var PasswordEncoderInterface|MockObject
     */
    private $passwordEncoder;

    /**
     * @var DateTimeGeneratorInterface|MockObject
     */
    private $dateTimeGenerator;

    /**
     * @var UserFactory
     */
    private $userFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->uuidGenerator = $this->createMock(UuidGeneratorInterface::class);
        $this->passwordEncoder = $this->createMock(PasswordEncoderInterface::class);
        $this->dateTimeGenerator = $this->createMock(DateTimeGeneratorInterface::class);

        $this->userFactory = new UserFactory(
            $this->uuidGenerator,
            $this->passwordEncoder,
            $this->dateTimeGenerator
        );
    }

    /**
     * @return void
     */
    public function testCreateFullUserFromUserRegisterCommand(): void
    {
        $id = $this->getUuid();
        $password = "some-password";
        $encodedPassword = "some-strong-password";
        $createdDateTime = new \DateTimeImmutable("now");

        $userRegisterCommand = new UserRegisterCommand(
            "some-email",
            $password
        );

        $userRegisterCommand->setFullName("some-full-name");

        $this->uuidGenerator->method("getUuid")->willReturn($id);
        $this->passwordEncoder->method("encodePassword")->with($password)->willReturn($encodedPassword);
        $this->dateTimeGenerator->method("getCurrentDateTimeImmutable")->willReturn($createdDateTime);

        $user = $this->userFactory->createFromUserRegisterCommand($userRegisterCommand);

        $this->assertEquals($user->getId(), $id->toString());
        $this->assertEquals($user->getEmail(), $userRegisterCommand->getEmail());
        $this->assertEquals($user->getPassword(), $encodedPassword);
        $this->assertEquals($user->getFullName(), $userRegisterCommand->getFullName());
	    $this->assertFalse($user->isVerified());
        $this->assertSame($user->getCreatedAt(), $createdDateTime);
    }
}