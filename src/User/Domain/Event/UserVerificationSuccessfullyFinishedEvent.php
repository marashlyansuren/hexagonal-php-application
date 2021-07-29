<?php

namespace App\User\Domain\Event;

use App\Common\AbstractEvent;
use App\User\Domain\User;
use App\User\Domain\UserVerification;

class UserVerificationSuccessfullyFinishedEvent extends AbstractEvent
{
	private const NAME = "user.verification.successfully.finished";

	/**
	 * @var UserVerification
	 */
	private UserVerification $userVerification;

	/**
	 * UserVerificationStartedEvent constructor.
	 *
	 * @param UserVerification   $userVerification
	 * @param \DateTimeImmutable $createdAt
	 */
	public function __construct(UserVerification $userVerification, \DateTimeImmutable $createdAt)
	{
		$this->userVerification = $userVerification;

		$this->name      = self::NAME;
		$this->createdAt = $createdAt;
	}

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->userVerification->getUser();
	}
}
