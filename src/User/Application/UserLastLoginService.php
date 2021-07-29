<?php

namespace App\User\Application;

use App\User\Domain\User;
use App\Common\DateTimeGeneratorInterface;
use App\User\Application\Port\In\UserLastLoginCommand;
use App\User\Application\Port\In\UpdateUserLastLoginUseCase;

class UserLastLoginService implements UpdateUserLastLoginUseCase
{
	/**
	 * @var DateTimeGeneratorInterface
	 */
	private DateTimeGeneratorInterface $dateTimeGenerator;

	/**
	 * UserLastLoginService constructor.
	 *
	 * @param DateTimeGeneratorInterface $dateTimeGenerator
	 */
	public function __construct(DateTimeGeneratorInterface $dateTimeGenerator)
	{
		$this->dateTimeGenerator = $dateTimeGenerator;
	}

	/**
	 * @param UserLastLoginCommand $userLastLoginCommand
	 *
	 * @return User
	 */
	public function lastLogin(UserLastLoginCommand $userLastLoginCommand): User
	{
		$user = $userLastLoginCommand->getUser();
		$user->setLastLogin($this->dateTimeGenerator->getCurrentDateTimeImmutable());

		return $user;
	}
}
