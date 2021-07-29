<?php

namespace App\Tests\User\Domain;

use App\Common\UuidInterface;
use App\Tests\ApplicationTestCase;
use App\User\Domain\User;
use App\User\Domain\UserGender;
use App\User\Domain\UserStatus;

class UserTest extends ApplicationTestCase
{
	public function testDefaultInitiationBehavior(): void
	{
		$uuid = $this->createMock(UuidInterface::class);
		$uuidString = "some-string";
		$createdDateTime = new \DateTimeImmutable("now");

		$uuid->method("toString")->willReturn($uuidString);

		$user = new User($uuid, "some-email", "some-password", $createdDateTime);

		$this->assertEquals($uuidString, $user->getId());
		$this->assertFalse($user->isVerified());
		$this->assertEquals(UserGender::notProvided(), $user->getGender());
		$this->assertEquals(UserStatus::active(), $user->getStatus());
		$this->assertEquals($createdDateTime, $user->getCreatedAt());
	}
}