<?php

namespace App\User\Adapter\In\Web\Request;

use App\User\Application\Port\In\UserRegisterCommand;

class UserRegisterRequestMapper
{
	/**
	 * @param UserRegisterRequest $userRegisterRequest
	 *
	 * @return UserRegisterCommand
	 */
	public function mapToUserRegisterCommand(UserRegisterRequest $userRegisterRequest): UserRegisterCommand
	{
		$userRegisterCommand = new UserRegisterCommand(
			$userRegisterRequest->email,
			$userRegisterRequest->password
		);

		$userRegisterCommand->setFullName($userRegisterRequest->fullName);
		$userRegisterCommand->setDisplayName($userRegisterRequest->displayName);

		return $userRegisterCommand;
	}
}
