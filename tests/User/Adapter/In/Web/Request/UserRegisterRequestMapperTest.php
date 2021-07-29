<?php

namespace App\Tests\User\Adapter\In\Web\Request;


use App\User\Adapter\In\Web\Request\UserRegisterRequest;
use App\User\Adapter\In\Web\Request\UserRegisterRequestMapper;
use PHPUnit\Framework\TestCase;

class UserRegisterRequestMapperTest extends TestCase
{
    private UserRegisterRequestMapper $userRegisterRequestMapper;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->userRegisterRequestMapper = new UserRegisterRequestMapper();
    }

    /**
     * @return void
     */
    public function testSuccessfullyMapToUserRegisterCommand(): void
    {
        $userRegisterRequest = $this->getUserRegisterRequestStubForEducator();

        $userRegisterCommand = $this->userRegisterRequestMapper->mapToUserRegisterCommand($userRegisterRequest);
        $this->assertEquals($userRegisterRequest->email, $userRegisterCommand->getEmail());
        $this->assertEquals($userRegisterRequest->password, $userRegisterCommand->getPassword());
        $this->assertEquals($userRegisterRequest->fullName, $userRegisterCommand->getFullName());
    }

    /**
     * @return UserRegisterRequest
     */
    private function getUserRegisterRequestStubForEducator(): UserRegisterRequest
    {
        $userRegisterRequest = new UserRegisterRequest();
        $userRegisterRequest->email = "some-email";
        $userRegisterRequest->password = "some-password";
        $userRegisterRequest->fullName = "some-full-name";

        return $userRegisterRequest;
    }
}