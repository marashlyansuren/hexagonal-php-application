<?php

namespace App\User\Application\Port\In;

use App\User\Domain\User;

class UserVerificationConfirmCommand
{

	private User $user;

	private string $token;

	/**
	 * UserVerificationConfirmCommand constructor.
	 *
	 * @param User   $user
	 * @param string $token
	 */
	public function __construct(User $user, string $token)
	{
		$this->user  = $user;
		$this->token = $token;
	}

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}

	/**
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token;
	}
}
