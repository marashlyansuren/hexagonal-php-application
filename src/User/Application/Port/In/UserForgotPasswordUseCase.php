<?php

namespace App\User\Application\Port\In;

use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\UserForgotPasswordAttempt;

interface UserForgotPasswordUseCase
{
	/**
	 * @param UserForgotPasswordNotificationCommand $userForgetPasswordNotificationCommand
	 *
	 * @return UserForgotPasswordAttempt
	 * @throws UserNotFoundException
	 */
	public function sendNotification(UserForgotPasswordNotificationCommand $userForgetPasswordNotificationCommand): UserForgotPasswordAttempt;
}
