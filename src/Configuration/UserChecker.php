<?php

namespace App\Configuration;

use App\User\Domain\User;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
	public function checkPreAuth(UserInterface $user): void
	{
		if ($user instanceof User && $user->isDeactivated()) {
			// the message passed to this exception is meant to be displayed to the user
			throw new BadCredentialsException('Invalid credentials.', 401);
		}
	}

	public function checkPostAuth(UserInterface $user): void
	{
		// TODO: Implement checkPostAuth() method.
	}
}