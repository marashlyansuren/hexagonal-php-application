<?php

namespace App\User\Application\Port\In;

use App\User\Domain\User;

interface UserActivationUseCase
{
	/**
	 * @param UserActivateCommand $userActivateCommand
	 *
	 * @return User
	 */
	public function activate(UserActivateCommand $userActivateCommand): User;
}
