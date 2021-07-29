<?php

namespace App\User\Adapter\In\Web\Request;

use App\User\Application\Port\In\UserForgotPasswordNotificationCommand;
use App\User\Application\Port\In\UserResetPasswordCommand;

class UserForgotPasswordAttemptRequestMapper
{
	/**
	 * @param UserForgotPasswordAttemptRequest $userForgotPasswordAttemptRequest
	 *
	 * @return UserForgotPasswordNotificationCommand
	 */
	public function mapToUserForgotPasswordNotificationCommand(
		UserForgotPasswordAttemptRequest $userForgotPasswordAttemptRequest
	): UserForgotPasswordNotificationCommand {
		return new UserForgotPasswordNotificationCommand($userForgotPasswordAttemptRequest->email);
	}

	/**
	 * @param string $token
	 * @param UserForgotPasswordResetRequest $userForgotPasswordResetRequest
	 *
	 * @return UserResetPasswordCommand
	 */
	public function mapToUserResetPasswordCommand(
		string $token,
		UserForgotPasswordResetRequest $userForgotPasswordResetRequest
	): UserResetPasswordCommand {
		return new UserResetPasswordCommand($token, $userForgotPasswordResetRequest->password);
	}
}
