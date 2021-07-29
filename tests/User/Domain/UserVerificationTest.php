<?php

namespace App\Tests\User\Domain;

use App\Common\UuidInterface;
use App\Tests\ApplicationTestCase;
use App\User\Domain\User;
use App\User\Domain\UserVerification;
use App\User\Domain\UserVerificationStatus;

class UserVerificationTest extends ApplicationTestCase
{
	public function testDefaultInitiationBehavior(): void
	{
		$uuid = $this->createMock(UuidInterface::class);
		$user = $this->createMock(User::class);
		$token = "some-token";
		$createdDateTime = new \DateTimeImmutable("now");

		$userVerification = new UserVerification($uuid, $user, $token, $createdDateTime);

		$this->assertEquals(UserVerificationStatus::created(), $userVerification->getStatus());
		$this->assertEquals($user, $userVerification->getUser());
		$this->assertEquals($token, $userVerification->getToken());
		$this->assertEquals($createdDateTime, $userVerification->getCreatedAt());
	}
}