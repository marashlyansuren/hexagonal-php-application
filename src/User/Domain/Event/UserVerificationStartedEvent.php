<?php

namespace App\User\Domain\Event;

use App\Common\AbstractEvent;
use App\User\Domain\UserVerification;

class UserVerificationStartedEvent extends AbstractEvent
{
	private const NAME = "user.verification.started";

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
}
