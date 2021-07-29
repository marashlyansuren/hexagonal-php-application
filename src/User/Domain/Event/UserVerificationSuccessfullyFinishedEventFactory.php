<?php

namespace App\User\Domain\Event;

use App\Common\AbstractEventFactory;
use App\User\Domain\UserVerification;

class UserVerificationSuccessfullyFinishedEventFactory extends AbstractEventFactory
{
	public function create(UserVerification $userVerification): UserVerificationSuccessfullyFinishedEvent
	{
		return new UserVerificationSuccessfullyFinishedEvent($userVerification, $this->dateTimeGenerator->getCurrentDateTimeImmutable());
	}
}
