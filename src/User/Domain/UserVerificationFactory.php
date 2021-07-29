<?php

namespace App\User\Domain;

use App\Common\DateTimeGeneratorInterface;
use App\Common\HashGeneratorInterface;
use App\Common\UuidGeneratorInterface;

class UserVerificationFactory
{
	private UuidGeneratorInterface $uuidGenerator;

	private HashGeneratorInterface $hashGeneratorInterface;

	private DateTimeGeneratorInterface $dateTimeGenerator;

	/**
	 * UserVerificationFactory constructor.
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
	 * @return UserVerification
	 */
	public function create(User $user): UserVerification
	{
		return new UserVerification(
			$this->uuidGenerator->getUuid(),
			$user,
			$this->hashGeneratorInterface->createRandomHash(),
			$this->dateTimeGenerator->getCurrentDateTimeImmutable()
		);
	}
}
