<?php

namespace App\User\Application\Port\Out;

use App\User\Application\Exception\UserVerificationException;
use App\User\Domain\User;
use App\User\Domain\UserVerification;

interface LoadUserVerificationPort
{
	/**
	 * @param string $id
	 * @param string $userId
	 *
	 * @return UserVerification
	 * @throws UserVerificationException
	 */
	public function getByIdAndUserId(string $id, string $userId): UserVerification;

	/**
	 * @param string $token
	 * @param string $userId
	 * @param int    $status
	 *
	 * @return UserVerification
	 */
	public function getByTokenUserIdAndStatus(string $token, string $userId, int $status): UserVerification;

	/**
	 * @param string $userId
	 *
	 * @return array<UserVerification>
	 */
	public function findAllByUserId(string $userId): array;
}
