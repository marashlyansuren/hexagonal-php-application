<?php

namespace App\User\Application\Port\In;

class UserForgotPasswordNotificationCommand
{
	private string $email;

	/**
	 * UserForgetPasswordNotificationCommand constructor.
	 *
	 * @param string $email
	 */
	public function __construct(string $email)
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}
}
