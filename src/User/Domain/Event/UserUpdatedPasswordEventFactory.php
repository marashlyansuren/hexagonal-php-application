<?php

namespace App\User\Domain\Event;

use App\Common\AbstractEventFactory;
use App\User\Domain\User;

class UserUpdatedPasswordEventFactory extends AbstractEventFactory
{
	/**
	 * @param User $user
	 *
	 * @return UserUpdatedPasswordEvent
	 */
	public function fromUser(User $user): UserUpdatedPasswordEvent
	{
		return new UserUpdatedPasswordEvent($user, $this->dateTimeGenerator->getCurrentDateTimeImmutable());
	}
}
