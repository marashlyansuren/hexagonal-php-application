<?php

namespace App\User\Domain\Event;

use App\Common\AbstractEventFactory;
use App\User\Domain\User;

class UserRegisteredEventFactory extends AbstractEventFactory
{
	/**
	 * @param User $user
	 *
	 * @return UserRegisteredEvent
	 */
	public function fromUser(User $user): UserRegisteredEvent
	{
		return new UserRegisteredEvent($user, $this->dateTimeGenerator->getCurrentDateTimeImmutable());
	}
}
