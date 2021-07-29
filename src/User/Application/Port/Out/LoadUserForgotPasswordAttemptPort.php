<?php

namespace App\User\Application\Port\Out;

use App\User\Application\Exception\UserForgotPasswordException;
use App\User\Domain\UserForgotPasswordAttempt;

interface LoadUserForgotPasswordAttemptPort
{
	/**
	 * @param string $token
	 * @param int    $status
	 *
	 * @return UserForgotPasswordAttempt
	 * @throws UserForgotPasswordException
	 */
	public function getByTokenAndStatus(string $token, int $status): UserForgotPasswordAttempt;

	/**
	 * @param string $userId
	 * @param int    $status
	 *
	 * @return array<UserForgotPasswordAttempt>
	 */
	public function findAllByUserIdAndStatus(string $userId, int $status): array;
}
