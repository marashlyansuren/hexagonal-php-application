<?php

namespace App\User\Application\Port\Out;

use App\User\Domain\UserVerification;

interface UpdateUserVerificationStatePort
{
	/**
	 * @param UserVerification $userVerification
	 */
	public function save(UserVerification $userVerification): void;
}
