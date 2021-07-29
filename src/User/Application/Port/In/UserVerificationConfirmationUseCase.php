<?php

namespace App\User\Application\Port\In;

use App\User\Application\Exception\UserNotFoundException;
use App\User\Application\Exception\UserVerificationException;
use App\User\Domain\UserVerification;

interface UserVerificationConfirmationUseCase
{
	/**
	 * @param UserVerificationConfirmCommand $userVerificationConfirmCommand
	 *
	 * @return UserVerification
	 * @throws UserNotFoundException
	 * @throws UserVerificationException
	 */
	public function confirm(UserVerificationConfirmCommand $userVerificationConfirmCommand): UserVerification;
}
