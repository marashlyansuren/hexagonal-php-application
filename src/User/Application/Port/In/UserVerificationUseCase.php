<?php

namespace App\User\Application\Port\In;

use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\UserVerification;

interface UserVerificationUseCase
{
	/**
	 * @param UserVerificationCommand $userValidationCommand
	 *
	 * @return UserVerification
	 * @throws UserNotFoundException
	 */
	public function startVerification(UserVerificationCommand $userValidationCommand): UserVerification;
}
