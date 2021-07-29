<?php

namespace App\User\Application;

use App\Common\DateTimeGeneratorInterface;
use App\User\Application\Port\In\UserVerificationCommand;
use App\User\Application\Port\In\UserVerificationConfirmationUseCase;
use App\User\Application\Port\In\UserVerificationConfirmCommand;
use App\User\Application\Port\In\UserVerificationUseCase;
use App\User\Application\Port\Out\LoadUserPort;
use App\User\Application\Port\Out\LoadUserVerificationPort;
use App\User\Application\Port\Out\UpdateUserVerificationStatePort;
use App\User\Domain\Event\UserVerificationStartedEventFactory;
use App\User\Domain\Event\UserVerificationSuccessfullyFinishedEventFactory;
use App\User\Domain\UserVerification;
use App\User\Domain\UserVerificationFactory;
use App\User\Domain\UserVerificationStatus;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

class UserVerificationService implements UserVerificationUseCase, UserVerificationConfirmationUseCase
{
	private DateTimeGeneratorInterface $dateTimeGenerator;

	private LoadUserPort $loadUserPort;

	private LoadUserVerificationPort $loadUserVerificationPort;

	private UpdateUserVerificationStatePort $updateUserVerificationStatePort;

	private UserVerificationFactory $userVerificationFactory;

	private UserVerificationStartedEventFactory $userVerificationStartedEventFactory;

	private UserVerificationSuccessfullyFinishedEventFactory $userVerificationSuccessfullyFinishedEventFactory;

	private PsrEventDispatcherInterface $eventDispatcher;

	/**
	 * UserVerificationService constructor.
	 *
	 * @param DateTimeGeneratorInterface                       $dateTimeGenerator
	 * @param LoadUserPort                                     $loadUserPort
	 * @param LoadUserVerificationPort                         $loadUserVerificationPort
	 * @param UpdateUserVerificationStatePort                  $updateUserVerificationStatePort
	 * @param UserVerificationFactory                          $userVerificationFactory
	 * @param UserVerificationStartedEventFactory              $userVerificationStartedEventFactory
	 * @param UserVerificationSuccessfullyFinishedEventFactory $userVerificationSuccessfullyFinishedEventFactory
	 * @param PsrEventDispatcherInterface                      $eventDispatcher
	 */
	public function __construct(
		DateTimeGeneratorInterface $dateTimeGenerator,
		LoadUserPort $loadUserPort,
		LoadUserVerificationPort $loadUserVerificationPort,
		UpdateUserVerificationStatePort $updateUserVerificationStatePort,
		UserVerificationFactory $userVerificationFactory,
		UserVerificationStartedEventFactory $userVerificationStartedEventFactory,
		UserVerificationSuccessfullyFinishedEventFactory $userVerificationSuccessfullyFinishedEventFactory,
		PsrEventDispatcherInterface $eventDispatcher
	) {
		$this->dateTimeGenerator                                = $dateTimeGenerator;
		$this->loadUserPort                                     = $loadUserPort;
		$this->loadUserVerificationPort                         = $loadUserVerificationPort;
		$this->updateUserVerificationStatePort                  = $updateUserVerificationStatePort;
		$this->userVerificationFactory                          = $userVerificationFactory;
		$this->userVerificationStartedEventFactory              = $userVerificationStartedEventFactory;
		$this->userVerificationSuccessfullyFinishedEventFactory = $userVerificationSuccessfullyFinishedEventFactory;
		$this->eventDispatcher                                  = $eventDispatcher;
	}

	/**
	 * {@inheritDoc}
	 */
	public function startVerification(UserVerificationCommand $userValidationCommand): UserVerification
	{
		$user = $userValidationCommand->getUser();

		$this->disableOldVerifications(...$this->loadUserVerificationPort->findAllByUserId($user->getId()));
		$userValidation = $this->userVerificationFactory->create($user);

		$this->updateUserVerificationStatePort->save($userValidation);
		$this->eventDispatcher->dispatch($this->userVerificationStartedEventFactory->create($userValidation));

		return $userValidation;
	}

	/**
	 * {@inheritDoc}
	 */
	public function confirm(UserVerificationConfirmCommand $userVerificationConfirmCommand): UserVerification
	{
		$userValidation = $this->loadUserVerificationPort->getByTokenUserIdAndStatus(
			$userVerificationConfirmCommand->getToken(),
			$userVerificationConfirmCommand->getUser()->getId(),
			UserVerificationStatus::created()->getValue()
		);

		$user = $userValidation->getUser();

		$userValidation->confirm($this->dateTimeGenerator->getCurrentDateTimeImmutable());
		$user->makeVerified();

		$this->eventDispatcher->dispatch($this->userVerificationSuccessfullyFinishedEventFactory->create($userValidation));

		return $userValidation;
	}

	/**
	 * @param UserVerification ...$userVerifications
	 */
	protected function disableOldVerifications(UserVerification ...$userVerifications): void
	{
		foreach ($userVerifications as $userVerification) {
			$userVerification->disable();
		}
	}
}
