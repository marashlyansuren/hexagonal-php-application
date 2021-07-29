<?php

namespace App\User\Adapter\Out\Persistence;

use App\User\Application\Exception\UserForgotPasswordException;
use App\User\Application\Port\Out\LoadUserForgotPasswordAttemptPort;
use App\User\Domain\UserForgotPasswordAttempt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserForgotPasswordAttemptRepository implements LoadUserForgotPasswordAttemptPort
{
	private ServiceEntityRepository $serviceEntityRepository;

	/**
	 * UserVerificationRepository constructor.
	 *
	 * @param ServiceEntityRepository $serviceEntityRepository
	 */
	public function __construct(ServiceEntityRepository $serviceEntityRepository)
	{
		$this->serviceEntityRepository = $serviceEntityRepository;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getByTokenAndStatus(string $token, int $status): UserForgotPasswordAttempt
	{
		$userForgotPasswordAttempt = $this->serviceEntityRepository->findOneBy(
			[
				"token" => $token,
				"status.value" => $status
			]
		);

		if (! $userForgotPasswordAttempt instanceof UserForgotPasswordAttempt) {
			throw UserForgotPasswordException::notFoundByTokenAndStatus($token, $status);
		}

		return $userForgotPasswordAttempt;
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAllByUserIdAndStatus(string $userId, int $status): array
	{
		return $this->serviceEntityRepository->findBy(
			[
				"user" => $userId,
				"status.value" => $status
			]
		);
	}
}
