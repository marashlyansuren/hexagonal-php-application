<?php

namespace App\User\Domain;

use App\Common\DateTimeGeneratorInterface;
use App\Common\PasswordEncoderInterface;
use App\Common\UuidGeneratorInterface;
use App\User\Application\Port\In\UserRegisterCommand;

class UserFactory
{
	private UuidGeneratorInterface $uuidGenerator;

	private PasswordEncoderInterface $passwordEncoder;

	private DateTimeGeneratorInterface $dateTimeGenerator;

	/**
	 * UserFactory constructor.
	 *
	 * @param UuidGeneratorInterface     $uuidGenerator
	 * @param PasswordEncoderInterface   $passwordEncoder
	 * @param DateTimeGeneratorInterface $dateTimeGenerator
	 */
	public function __construct(
		UuidGeneratorInterface $uuidGenerator,
		PasswordEncoderInterface $passwordEncoder,
		DateTimeGeneratorInterface $dateTimeGenerator
	) {
		$this->uuidGenerator     = $uuidGenerator;
		$this->passwordEncoder   = $passwordEncoder;
		$this->dateTimeGenerator = $dateTimeGenerator;
	}

	public function createFromUserRegisterCommand(UserRegisterCommand $userRegisterCommand): User
	{
		$user = new User(
			$this->uuidGenerator->getUuid(),
			$userRegisterCommand->getEmail(),
			$this->passwordEncoder->encodePassword($userRegisterCommand->getPassword()),
			$this->dateTimeGenerator->getCurrentDateTimeImmutable()
		);

		if ($fullName = $userRegisterCommand->getFullName()) {
			$user->setFullName($fullName);
		}

		if ($displayName = $userRegisterCommand->getDisplayName()) {
			$user->setDisplayName($displayName);
		}

		return $user;
	}
}
