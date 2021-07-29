<?php

namespace App\User\Application\Port\In;

use App\User\Domain\User;

class UserActivateCommand
{
	private User $user;

	/**
	 * UserActivateCommand constructor.
	 *
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}
}
