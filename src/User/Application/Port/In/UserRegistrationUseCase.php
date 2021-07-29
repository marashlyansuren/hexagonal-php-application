<?php

namespace App\User\Application\Port\In;

use App\User\Application\Exception\UserException;
use App\User\Domain\User;

interface UserRegistrationUseCase
{
	/**
	 * @param UserRegisterCommand $userRegisterCommand
	 *
	 * @return User
	 * @throws UserException when user email already exits
	 */
	public function register(UserRegisterCommand $userRegisterCommand): User;
}
