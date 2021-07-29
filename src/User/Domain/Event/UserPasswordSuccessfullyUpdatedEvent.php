<?php

namespace App\User\Domain\Event;

use App\Common\AbstractEvent;
use App\User\Domain\User;

class UserPasswordSuccessfullyUpdatedEvent extends AbstractEvent
{
	private const NAME = "user.updated.password";

	/**
	 * @var User
	 */
	private $user;

	/**
	 * UserRegisteredEvent constructor.
	 *
	 * @param User               $user
	 * @param \DateTimeImmutable $createdAt
	 */
	public function __construct(User $user, \DateTimeImmutable $createdAt)
	{
		$this->user      = $user;
		$this->createdAt = $createdAt;
		$this->name      = self::NAME;
	}

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}
}
