<?php

namespace App\User\Application\Port\In;

use App\User\Application\Exception\UserForgotPasswordException;
use App\User\Domain\UserForgotPasswordAttempt;

interface UserResetPasswordUseCase
{
	/**
	 * @param UserResetPasswordCommand $userResetPasswordCommand
	 *
	 * @return UserForgotPasswordAttempt
	 * @throws UserForgotPasswordException
	 */
	public function reset(UserResetPasswordCommand $userResetPasswordCommand): UserForgotPasswordAttempt;
}
