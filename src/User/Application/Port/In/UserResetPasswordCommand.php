<?php

namespace App\User\Application\Port\In;

class UserResetPasswordCommand
{
	private string $token;

	private string $password;

	/**
	 * UserResetPasswordCommand constructor.
	 *
	 * @param string $token
	 * @param string $password
	 */
	public function __construct(string $token, string $password)
	{
		$this->token    = $token;
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}
}
