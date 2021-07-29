<?php

namespace App\User\Adapter\Out\Persistence;

use App\User\Application\Port\Out\UpdateUserForgotPasswordAttemptStatePort;
use App\User\Domain\UserForgotPasswordAttempt;
use Doctrine\ORM\EntityManagerInterface;

class UserForgotPasswordAttemptPersistenceAdapter implements UpdateUserForgotPasswordAttemptStatePort
{
	private EntityManagerInterface $entityManager;

	/**
	 * UserVerificationPersistenceAdapter constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function save(UserForgotPasswordAttempt $userForgotPasswordAttempt): void
	{
		$this->entityManager->persist($userForgotPasswordAttempt);
	}
}
