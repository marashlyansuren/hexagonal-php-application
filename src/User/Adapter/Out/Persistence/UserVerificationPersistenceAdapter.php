<?php

namespace App\User\Adapter\Out\Persistence;

use App\User\Application\Port\Out\UpdateUserVerificationStatePort;
use App\User\Domain\UserVerification;
use Doctrine\ORM\EntityManagerInterface;

class UserVerificationPersistenceAdapter implements UpdateUserVerificationStatePort
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	/**
	 * UserVerificationPersistenceAdapter constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * {@inheritDoc}
	 */
	public function save(UserVerification $userVerification): void
	{
		$this->entityManager->persist($userVerification);
	}
}
