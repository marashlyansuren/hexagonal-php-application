<?php

namespace App\User\Domain;

use App\Common\DateTimeGeneratorInterface;
use App\Common\HashGeneratorInterface;
use App\Common\UuidGeneratorInterface;

class UserForgotPasswordAttemptFactory
{
	private UuidGeneratorInterface $uuidGenerator;

	private HashGeneratorInterface $hashGeneratorInterface;

	private DateTimeGeneratorInterface $dateTimeGenerator;

	/**
	 * UserForgotPasswordAttemptFactory constructor.
	 *
	 * @param UuidGeneratorInterface     $uuidGenerator
	 * @param HashGeneratorInterface     $hashGeneratorInterface
	 * @param DateTimeGeneratorInterface $dateTimeGenerator
	 */
	public function __construct(
		UuidGeneratorInterface $uuidGenerator,
		HashGeneratorInterface $hashGeneratorInterface,
		DateTimeGeneratorInterface $dateTimeGenerator
	) {
		$this->uuidGenerator          = $uuidGenerator;
		$this->hashGeneratorInterface = $hashGeneratorInterface;
		$this->dateTimeGenerator      = $dateTimeGenerator;
	}

	/**
	 * @param User $user
	 *
	 * @return UserForgotPasswordAttempt
	 */
	public function create(User $user): UserForgotPasswordAttempt
	{
		return new UserForgotPasswordAttempt(
			$this->uuidGenerator->getUuid()->toString(),
			$user,
			$this->hashGeneratorInterface->createRandomHash(),
			$this->dateTimeGenerator->getCurrentDateTimeImmutable()
		);
	}
}
