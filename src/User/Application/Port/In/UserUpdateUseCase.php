<?php

namespace App\User\Application\Port\In;

use App\User\Application\Exception\UserException;
use App\User\Domain\User;

interface UserUpdateUseCase
{
	/**
	 * @param UserUpdateCommand $userUpdateCommand
	 *
	 * @return User
	 * @throws UserException when user email already exits
	 */
	public function update(UserUpdateCommand $userUpdateCommand): User;
}
