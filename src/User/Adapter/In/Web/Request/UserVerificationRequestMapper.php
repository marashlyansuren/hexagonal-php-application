<?php

namespace App\User\Adapter\In\Web\Request;

use App\Common\UuidGeneratorInterface;
use App\User\Application\Port\In\UserVerificationCommand;
use App\User\Application\Port\In\UserVerificationConfirmCommand;
use App\User\Domain\User;

class UserVerificationRequestMapper
{
	private UuidGeneratorInterface $uuidGenerator;

	/**
	 * UserVerificationRequestMapper constructor.
	 *
	 * @param UuidGeneratorInterface $uuidGenerator
	 */
	public function __construct(UuidGeneratorInterface $uuidGenerator)
	{
		$this->uuidGenerator = $uuidGenerator;
	}

	/**
	 * @param User $user
	 *
	 * @return UserVerificationCommand
	 */
	public function mapToUserVerificationCommand(User $user): UserVerificationCommand
	{
		return new UserVerificationCommand($user);
	}

	/**
	 * @param User   $user
	 * @param string $token
	 *
	 * @return UserVerificationConfirmCommand
	 */
	public function mapToUserVerificationConfirmCommand(User $user, string $token): UserVerificationConfirmCommand
	{
		return new UserVerificationConfirmCommand($user, $token);
	}
}
