<?php

namespace App\User\Application;

use App\Common\DateTimeGeneratorInterface;
use App\Common\PasswordEncoderInterface;
use App\User\Application\Port\In\UserForgotPasswordNotificationCommand;
use App\User\Application\Port\In\UserForgotPasswordUseCase;
use App\User\Application\Port\In\UserResetPasswordCommand;
use App\User\Application\Port\In\UserResetPasswordUseCase;
use App\User\Application\Port\Out\LoadUserForgotPasswordAttemptPort;
use App\User\Application\Port\Out\LoadUserPort;
use App\User\Application\Port\Out\UpdateUserForgotPasswordAttemptStatePort;
use App\User\Domain\UserForgotPasswordAttempt;
use App\User\Domain\UserForgotPasswordAttemptFactory;
use App\User\Domain\UserForgotPasswordAttemptStatus;

class UserForgotPasswordService implements UserForgotPasswordUseCase, UserResetPasswordUseCase
{
	private DateTimeGeneratorInterface $dateTimeGenerator;

	private PasswordEncoderInterface $passwordEncoder;

	private LoadUserPort $loadUserPort;

	private LoadUserForgotPasswordAttemptPort $loadUserForgotPasswordAttemptPort;

	private UpdateUserForgotPasswordAttemptStatePort $updateUserForgotPasswordAttemptStatePort;

	private UserForgotPasswordAttemptFactory $userForgotPasswordAttemptFactory;

	/**
	 * UserForgotPasswordService constructor.
	 *
	 * @param DateTimeGeneratorInterface               $dateTimeGenerator
	 * @param PasswordEncoderInterface                 $passwordEncoder
	 * @param LoadUserPort                             $loadUserPort
	 * @param LoadUserForgotPasswordAttemptPort        $loadUserForgotPasswordAttemptPort
	 * @param UpdateUserForgotPasswordAttemptStatePort $updateUserForgotPasswordAttemptStatePort
	 * @param UserForgotPasswordAttemptFactory         $userForgotPasswordAttemptFactory
	 */
	public function __construct(
		DateTimeGeneratorInterface $dateTimeGenerator,
		PasswordEncoderInterface $passwordEncoder,
		LoadUserPort $loadUserPort,
		LoadUserForgotPasswordAttemptPort $loadUserForgotPasswordAttemptPort,
		UpdateUserForgotPasswordAttemptStatePort $updateUserForgotPasswordAttemptStatePort,
		UserForgotPasswordAttemptFactory $userForgotPasswordAttemptFactory
	) {
		$this->dateTimeGenerator                        = $dateTimeGenerator;
		$this->passwordEncoder                          = $passwordEncoder;
		$this->loadUserPort                             = $loadUserPort;
		$this->loadUserForgotPasswordAttemptPort        = $loadUserForgotPasswordAttemptPort;
		$this->updateUserForgotPasswordAttemptStatePort = $updateUserForgotPasswordAttemptStatePort;
		$this->userForgotPasswordAttemptFactory         = $userForgotPasswordAttemptFactory;
	}

	/**
	 * {@inheritDoc}
	 */
	public function sendNotification(UserForgotPasswordNotificationCommand $userForgetPasswordNotificationCommand): UserForgotPasswordAttempt
	{
		$user = $this->loadUserPort->getByEmail($userForgetPasswordNotificationCommand->getEmail());

		$this->disableOldAttempts(
			...$this->loadUserForgotPasswordAttemptPort->findAllByUserIdAndStatus(
				$user->getId(),
				UserForgotPasswordAttemptStatus::created()->getValue()
			)
		);

		$userForgotPasswordAttempt = $this->userForgotPasswordAttemptFactory->create($user);
		$this->updateUserForgotPasswordAttemptStatePort->save($userForgotPasswordAttempt);
		//trigger event for sending email

		return $userForgotPasswordAttempt;
	}

	/**
	 * {@inheritDoc}
	 */
	public function reset(UserResetPasswordCommand $userResetPasswordCommand): UserForgotPasswordAttempt
	{
		$userForgotPasswordAttempt = $this->loadUserForgotPasswordAttemptPort->getByTokenAndStatus(
			$userResetPasswordCommand->getToken(),
			UserForgotPasswordAttemptStatus::created()->getValue()
		);

		$userForgotPasswordAttempt->confirm($this->dateTimeGenerator->getCurrentDateTimeImmutable());

		$user = $userForgotPasswordAttempt->getUser();
		$user->resetPassword(
			$this->passwordEncoder->encodePassword($userResetPasswordCommand->getPassword())
		);

		return $userForgotPasswordAttempt;
	}

	/**
	 * @param UserForgotPasswordAttempt ...$userForgotPasswordAttempts
	 */
	protected function disableOldAttempts(UserForgotPasswordAttempt ...$userForgotPasswordAttempts): void
	{
		foreach ($userForgotPasswordAttempts as $userForgotPasswordAttempt) {
			$userForgotPasswordAttempt->disable($this->dateTimeGenerator->getCurrentDateTimeImmutable());
		}
	}
}
