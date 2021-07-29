<?php

namespace App\User\Application\Port\In;

use App\Common\UuidInterface;
use App\User\Domain\User;

class UserVerificationCommand
{
	private User $user;

	/**
	 * UserVerificationCommand constructor.
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
