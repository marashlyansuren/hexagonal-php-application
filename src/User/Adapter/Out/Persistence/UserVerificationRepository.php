<?php

namespace App\User\Adapter\Out\Persistence;

use App\User\Application\Exception\UserVerificationException;
use App\User\Application\Port\Out\LoadUserVerificationPort;
use App\User\Domain\UserVerification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserVerificationRepository implements LoadUserVerificationPort
{
	/**
	 * @var ServiceEntityRepository
	 */
	private $serviceEntityRepository;

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
	public function getByIdAndUserId(string $id, string $userId): UserVerification
	{
		$userVerification = $this->serviceEntityRepository->findOneBy(
			[
				"id" => $id,
				"user" => $userId
			]
		);

		if (! $userVerification instanceof UserVerification) {
			throw UserVerificationException::notFoundByIdAndUserId($id, $userId);
		}

		return $userVerification;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getByTokenUserIdAndStatus(string $token, string $userId, int $status): UserVerification
	{
		$userVerification = $this->serviceEntityRepository->findOneBy(
			[
				"token" => $token,
				"user" => $userId,
				"status.value" => $status
			]
		);

		if (! $userVerification instanceof UserVerification) {
			throw UserVerificationException::notFoundByTokenUserIdAndStatus($token, $userId, $status);
		}

		return $userVerification;
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAllByUserId(string $userId): array
	{
		return $this->serviceEntityRepository->findBy(
			[
				"user" => $userId
			]
		);
	}
}
