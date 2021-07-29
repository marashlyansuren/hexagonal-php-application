<?php

namespace App\User\Application;

use App\User\Application\Port\In\UserDeactivateCommand;
use App\User\Application\Port\In\UserDeactivationUseCase;
use App\User\Domain\User;

class UserDeactivationService implements UserDeactivationUseCase
{
	/**
	 * {@inheritdoc}
	 */
	public function delete(UserDeactivateCommand $userDeactivateCommand): User
	{
		$user = $userDeactivateCommand->getUser();
		$user->deactivate();

		//trigger event here if there any business logic to apply on user deactivation

		return $user;
	}
}
