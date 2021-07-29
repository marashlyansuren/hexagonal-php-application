<?php

namespace App\Tests\User\Adapter\In\Web\Response;

use App\Common\ResponseEntity;
use App\Tests\ApplicationTestCase;
use App\User\Adapter\In\Web\Response\UserResponse;
use App\User\Adapter\In\Web\Response\UserResponseMapper;
use App\User\Domain\User;
use App\User\Domain\UserType;

class UserResponseMapperTest extends ApplicationTestCase
{
    private UserResponseMapper $userResponseMapper;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->userResponseMapper = new UserResponseMapper();
    }

    public function testSuccessfullyMapFromUserDomainEntity(): void
    {
        $id = $this->getUuid();
        $email = "some-email";
        $dateTime = new \DateTimeImmutable("now");

        $user = new User(
            $id,
            $email,
            "some-password",
            $dateTime
        );

        $userResponse = $this->userResponseMapper->mapFromUserDomainEntity($user);

        $this->assertEquals($userResponse->getId(), $id->toString());
        $this->assertEquals($userResponse->getEmail(), $email);
        $this->assertEquals($userResponse->getCreatedAt(), $dateTime->format(ResponseEntity::DATE_TIME_FORMAT));
        $this->assertNull($userResponse->getFullName());
    }
}