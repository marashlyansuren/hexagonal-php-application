<?php

namespace App\User\Application;

use App\Common\DateTimeGeneratorInterface;
use App\Common\PasswordEncoderInterface;
use App\User\Application\Exception\UserException;
use App\User\Application\Port\Out\LoadUserPort;
use App\User\Domain\Event\UserPasswordSuccessfullyUpdatedEventFactory;
use App\User\Application\Port\In\UserUpdateCommand;
use App\User\Application\Port\In\UserUpdateUseCase;
use App\User\Domain\User;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

class UserUpdateService implements UserUpdateUseCase
{
	/**
	 * @var DateTimeGeneratorInterface
	 */
	private DateTimeGeneratorInterface $dateTimeGenerator;

	private UserPasswordSuccessfullyUpdatedEventFactory $userPasswordSuccessfullyUpdatedEventFactory;

	private PsrEventDispatcherInterface $eventDispatcher;

	private PasswordEncoderInterface $passwordEncoder;

	private LoadUserPort $loadUserPort;

	/**
	 * UserUpdateService constructor.
	 *
	 * @param UserPasswordSuccessfullyUpdatedEventFactory $userPasswordSuccessfullyUpdatedEventFactory
	 * @param PsrEventDispatcherInterface                 $eventDispatcher
	 * @param DateTimeGeneratorInterface                  $dateTimeGenerator
	 * @param PasswordEncoderInterface                    $passwordEncoder
	 * @param LoadUserPort                                $loadUserPort
	 */
	public function __construct(
		UserPasswordSuccessfullyUpdatedEventFactory $userPasswordSuccessfullyUpdatedEventFactory,
		PsrEventDispatcherInterface $eventDispatcher,
		DateTimeGeneratorInterface $dateTimeGenerator,
		PasswordEncoderInterface $passwordEncoder,
		LoadUserPort $loadUserPort
	) {
		$this->userPasswordSuccessfullyUpdatedEventFactory = $userPasswordSuccessfullyUpdatedEventFactory;
		$this->eventDispatcher                             = $eventDispatcher;
		$this->dateTimeGenerator                           = $dateTimeGenerator;
		$this->passwordEncoder                             = $passwordEncoder;
		$this->loadUserPort                                = $loadUserPort;
	}

	/**
	 * {@inheritdoc}
	 */
	public function update(UserUpdateCommand $userUpdateCommand): User
	{
		$user = $userUpdateCommand->getUser();
		$this->populateData($user, $userUpdateCommand);
		$user->setUpdatedAt($this->dateTimeGenerator->getCurrentDateTimeImmutable());

		return $user;
	}

	private function populateData(User $user, UserUpdateCommand $userUpdateCommand): void
	{
		if ($fullName = $userUpdateCommand->getFullName()) {
			$user->setFullName($fullName);
		}

		if ($displayName = $userUpdateCommand->getDisplayName()) {
			$user->setDisplayName($displayName);
		}

		if ($birthday = $userUpdateCommand->getBirthday()) {
			$user->setBirthday($birthday);
		}

		if ($gender = $userUpdateCommand->getGender()) {
			$user->setGender($gender);
		}

		$passwordOld = $userUpdateCommand->getPasswordOld();
		$password    = $userUpdateCommand->getPassword();
		if (!empty($passwordOld) && !empty($password)) {
			if (!$this->passwordEncoder->isPasswordValid($user->getPassword(), $passwordOld)) {
				throw UserException::passwordNotExistsException($passwordOld);
			}

			$user->setPassword($this->passwordEncoder->encodePassword($password));
			$this->eventDispatcher->dispatch($this->userPasswordSuccessfullyUpdatedEventFactory->fromUser($user));
		}
	}
}
