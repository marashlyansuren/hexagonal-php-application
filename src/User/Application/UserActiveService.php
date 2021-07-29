<?php

namespace App\User\Application;

use App\User\Application\Port\In\UserActivateCommand;
use App\User\Application\Port\In\UserActivationUseCase;
use App\User\Domain\User;

class UserActiveService implements UserActivationUseCase
{
	/**
	 * {@inheritdoc}
	 */
	public function activate(UserActivateCommand $userActivateCommand): User
	{
		$user = $userActivateCommand->getUser();
		$user->activate();

		return $user;
	}
}
