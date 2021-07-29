<?php

namespace App\User\Application\Port\In;

class UserRegisterCommand
{
	private string $email;

	private string $password;

	private ?string $fullName = null;

	private ?string $displayName = null;

	/**
	 * UserRegisterCommand constructor.
	 *
	 * @param string   $email
	 * @param string   $password
	 */
	public function __construct(string $email, string $password)
	{
		$this->email    = $email;
		$this->password = $password;
	}

	/**
	 * @param string|null $fullName
	 */
	public function setFullName(?string $fullName): void
	{
		$this->fullName = $fullName;
	}

	/**
	 * @param string|null $displayName
	 */
	public function setDisplayName(?string $displayName): void
	{
		$this->displayName = $displayName;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @return string|null
	 */
	public function getFullName(): ?string
	{
		return $this->fullName;
	}

	/**
	 * @return string|null
	 */
	public function getDisplayName(): ?string
	{
		return $this->displayName;
	}
}
