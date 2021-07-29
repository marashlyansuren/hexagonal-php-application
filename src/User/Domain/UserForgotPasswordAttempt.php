<?php

namespace App\User\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_forgot_password_attempt")
 */
class UserForgotPasswordAttempt
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="guid")
	 */
	private string $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\User\Domain\User")
	 * @ORM\JoinColumn(name="user_id",                     referencedColumnName="id")
	 */
	private User $user;

	/**
	 * @ORM\Column(name="token", unique=true)
	 */
	private string $token;

	/**
	 * @ORM\Embedded(class="App\User\Domain\UserForgotPasswordAttemptStatus", columnPrefix=false)
	 */
	private UserForgotPasswordAttemptStatus $status;

	/**
	 * @ORM\Column(type="datetime_immutable", name="created_at")
	 */
	private \DateTimeImmutable $createdAt;

	/**
	 * @ORM\Column(type="datetime_immutable", name="updated_at", nullable=true)
	 */
	private \DateTimeImmutable $updatedAt;

	/**
	 * UserForgotPasswordAttempt constructor.
	 *
	 * @param string             $id
	 * @param User               $user
	 * @param string             $token
	 * @param \DateTimeImmutable $createdAt
	 */
	public function __construct(string $id, User $user, string $token, \DateTimeImmutable $createdAt)
	{
		$this->id        = $id;
		$this->user      = $user;
		$this->token     = $token;
		$this->createdAt = $createdAt;

		$this->status = UserForgotPasswordAttemptStatus::created();
	}

	/**
	 * @return UserForgotPasswordAttemptStatus
	 */
	public function getStatus(): UserForgotPasswordAttemptStatus
	{
		return $this->status;
	}

	/**
	 * //@TODO tmp remove this after integrating emails
	 *
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token;
	}

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}

	public function confirm(\DateTimeImmutable $updatedAt): void
	{
		$this->status    = UserForgotPasswordAttemptStatus::confirmed();
		$this->updatedAt = $updatedAt;
	}

	public function disable(\DateTimeImmutable $updatedAt): void
	{
		$this->status    = UserForgotPasswordAttemptStatus::disabled();
		$this->updatedAt = $updatedAt;
	}
}
