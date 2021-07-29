<?php

namespace App\User\Domain\Event;

use App\Common\AbstractEventFactory;
use App\User\Domain\User;

class UserPasswordSuccessfullyUpdatedEventFactory extends AbstractEventFactory
{
	/**
	 * @param User $user
	 *
	 * @return UserPasswordSuccessfullyUpdatedEvent
	 */
	public function fromUser(User $user): UserPasswordSuccessfullyUpdatedEvent
	{
		return new UserPasswordSuccessfullyUpdatedEvent($user, $this->dateTimeGenerator->getCurrentDateTimeImmutable());
	}
}
