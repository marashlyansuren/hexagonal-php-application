<?php

namespace App\User\Application\Port\In;

use App\User\Domain\User;

interface UserDeactivationUseCase
{
	/**
	 * @param UserDeactivateCommand $userDeactivateCommand
	 *
	 * @return User
	 */
	public function delete(UserDeactivateCommand $userDeactivateCommand): User;
}
