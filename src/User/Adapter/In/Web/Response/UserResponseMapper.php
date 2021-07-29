<?php

namespace App\User\Adapter\In\Web\Response;

use App\User\Domain\User;

class UserResponseMapper
{
	public function mapFromUserDomainEntity(User $user): UserResponse
	{
		$userResponse = new UserResponse();
		$userResponse->setId($user->getId());
		$userResponse->setEmail($user->getEmail());
		$userResponse->setFullName($user->getFullName());
		$userResponse->setDisplayName($user->getDisplayName());
		$userResponse->setBirthDay($user->getBirthday());
		$userResponse->setGender($user->getGender());
		$userResponse->setVerified($user->isVerified());
		$userResponse->setStatus($user->getStatus());
		$userResponse->setCreatedAt($user->getCreatedAt());

		return $userResponse;
	}
}
