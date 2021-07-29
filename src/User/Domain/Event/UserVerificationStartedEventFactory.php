<?php

namespace App\User\Domain\Event;

use App\Common\AbstractEventFactory;
use App\User\Domain\UserVerification;

class UserVerificationStartedEventFactory extends AbstractEventFactory
{
	public function create(UserVerification $userVerification): UserVerificationStartedEvent
	{
		return new UserVerificationStartedEvent($userVerification, $this->dateTimeGenerator->getCurrentDateTimeImmutable());
	}
}
