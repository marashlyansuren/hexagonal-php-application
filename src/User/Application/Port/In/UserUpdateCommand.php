<?php

namespace App\User\Application\Port\In;

use App\User\Domain\User;
use App\User\Domain\UserGender;

class UserUpdateCommand
{
	private User $user;

	private ?string $fullName = null;

	private ?string $displayName = null;

	private ?string $password = null;

	private ?string $passwordOld = null;

	private ?\DateTimeImmutable $birthday = null;

	private ?UserGender $gender = null;

	/**
	 * UserUpdateCommand constructor.
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

	/**
	 * @return string|null
	 */
	public function getFullName(): ?string
	{
		return $this->fullName;
	}

	/**
	 * @param string|null $fullName
	 */
	public function setFullName(?string $fullName): void
	{
		$this->fullName = $fullName;
	}

	/**
	 * @return string|null
	 */
	public function getDisplayName(): ?string
	{
		return $this->displayName;
	}

	/**
	 * @param string|null $displayName
	 */
	public function setDisplayName(?string $displayName): void
	{
		$this->displayName = $displayName;
	}

	/**
	 * @return string|null
	 */
	public function getPassword(): ?string
	{
		return $this->password;
	}

	/**
	 * @param string|null $password
	 */
	public function setPassword(?string $password): void
	{
		$this->password = $password;
	}

	/**
	 * @return string|null
	 */
	public function getPasswordOld(): ?string
	{
		return $this->passwordOld;
	}

	/**
	 * @param string|null $passwordOld
	 */
	public function setPasswordOld(?string $passwordOld): void
	{
		$this->passwordOld = $passwordOld;
	}

	/**
	 * @return \DateTimeImmutable|null
	 */
	public function getBirthday(): ?\DateTimeImmutable
	{
		return $this->birthday;
	}

	/**
	 * @param \DateTimeImmutable|null $birthday
	 */
	public function setBirthday(?\DateTimeImmutable $birthday): void
	{
		$this->birthday = $birthday;
	}

	/**
	 * @return UserGender|null
	 */
	public function getGender(): ?UserGender
	{
		return $this->gender;
	}

	/**
	 * @param UserGender|null $gender
	 */
	public function setGender(?UserGender $gender): void
	{
		$this->gender = $gender;
	}
}
