<?php

namespace App\User\Application\Port\Out;

use App\User\Domain\User;

interface UpdateUserStatePort
{
	/**
	 * @param User $user
	 */
	public function save(User $user): void;
}
