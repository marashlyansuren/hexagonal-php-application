<?php

namespace App\User\Application\Port\In;

use App\User\Domain\User;

class UserLastLoginCommand
{
	private User $user;

	/**
	 * UserLastLoginCommand constructor.
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
