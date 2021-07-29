<?php

namespace App\User\Application\Port\Out;

use App\User\Domain\UserForgotPasswordAttempt;

interface UpdateUserForgotPasswordAttemptStatePort
{
	/**
	 * @param UserForgotPasswordAttempt $userForgotPasswordAttempt
	 */
	public function save(UserForgotPasswordAttempt $userForgotPasswordAttempt): void;
}
