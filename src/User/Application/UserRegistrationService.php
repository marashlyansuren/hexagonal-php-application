<?php

namespace App\User\Application;

use App\User\Application\Exception\UserException;
use App\User\Application\Port\In\UserRegisterCommand;
use App\User\Application\Port\In\UserRegistrationUseCase;
use App\User\Application\Port\Out\LoadUserPort;
use App\User\Application\Port\Out\UpdateUserStatePort;
use App\User\Domain\Event\UserRegisteredEventFactory;
use App\User\Domain\User;
use App\User\Domain\UserFactory;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

class UserRegistrationService implements UserRegistrationUseCase
{
	private UserFactory $userFactory;

	private UserRegisteredEventFactory $userRegisteredEventFactory;

	private LoadUserPort $loadUserPort;

	private UpdateUserStatePort $updateUserStatePort;

	private PsrEventDispatcherInterface $eventDispatcher;

	/**
	 * UserRegistrationService constructor.
	 *
	 * @param UserFactory                 $userFactory
	 * @param UserRegisteredEventFactory  $userRegisteredEventFactory
	 * @param LoadUserPort                $loadUserPort
	 * @param UpdateUserStatePort         $updateUserStatePort
	 * @param PsrEventDispatcherInterface $eventDispatcher
	 */
	public function __construct(
		UserFactory $userFactory,
		UserRegisteredEventFactory $userRegisteredEventFactory,
		LoadUserPort $loadUserPort,
		UpdateUserStatePort $updateUserStatePort,
		PsrEventDispatcherInterface $eventDispatcher
	) {
		$this->userFactory                = $userFactory;
		$this->userRegisteredEventFactory = $userRegisteredEventFactory;
		$this->loadUserPort               = $loadUserPort;
		$this->updateUserStatePort        = $updateUserStatePort;
		$this->eventDispatcher            = $eventDispatcher;
	}

	/**
	 * {@inheritdoc}
	 */
	public function register(UserRegisterCommand $userRegisterCommand): User
	{
		if ($this->loadUserPort->findByEmail($userRegisterCommand->getEmail())) {
			throw UserException::emailAlreadyExistsException($userRegisterCommand->getEmail());
		}

		$user = $this->userFactory->createFromUserRegisterCommand($userRegisterCommand);
		$this->updateUserStatePort->save($user);

		$this->eventDispatcher->dispatch($this->userRegisteredEventFactory->fromUser($user));

		return $user;
	}
}
