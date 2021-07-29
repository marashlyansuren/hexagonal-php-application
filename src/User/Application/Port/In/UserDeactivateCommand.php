<?php

namespace App\User\Application\Port\In;

use App\User\Domain\User;

class UserDeactivateCommand
{
	private User $user;

	/**
	 * UserDeactivateCommand constructor.
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
