<?php

namespace App\User\Application\Port\In;

use App\User\Domain\User;

interface UpdateUserLastLoginUseCase
{
	/**
	 * @param UserLastLoginCommand $userLastLoginCommand
	 *
	 * @return User
	 */
	public function lastLogin(UserLastLoginCommand $userLastLoginCommand): User;
}
