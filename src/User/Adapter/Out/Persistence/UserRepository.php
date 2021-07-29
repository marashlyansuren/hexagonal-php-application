<?php

namespace App\User\Adapter\Out\Persistence;

use App\User\Application\Exception\UserNotFoundException;
use App\User\Application\Port\Out\LoadUserPort;
use App\User\Domain\User;
use App\User\Domain\UserStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements LoadUserPort
{
	/**
	 * @var ServiceEntityRepository
	 */
	private ServiceEntityRepository $serviceEntityRepository;

	/**
	 * @var EntityManagerInterface
	 */
	private EntityManagerInterface $entityManager;

	/**
	 * UserRepository constructor.
	 *
	 * @param ServiceEntityRepository $serviceEntityRepository
	 * @param EntityManagerInterface  $entityManager
	 */
	public function __construct(ServiceEntityRepository $serviceEntityRepository, EntityManagerInterface $entityManager)
	{
		$this->serviceEntityRepository = $serviceEntityRepository;
		$this->entityManager           = $entityManager;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getUserById(string $id): User
	{
		$user = $this->serviceEntityRepository->find($id);
		if (! $user instanceof User) {
			throw UserNotFoundException::byId($id);
		}

		return $user;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getByEmail(string $email): User
	{
		$user = $this->findByEmail($email);
		if (! $user instanceof User) {
			throw UserNotFoundException::byEmail($email);
		}

		return $user;
	}

	/**
	 * @param string $email
	 *
	 * @return User|null
	 */
	public function findByEmail(string $email): ?User
	{
		/**
		 * @var User $user
		 */
		$user = $this->serviceEntityRepository->findOneBy(
			[
				"email" => $email
			]
		);

		return $user;
	}

	/**
	 * @param int $days
	 *
	 * @return bool
	 */
	public function deleteInactiveUsersOlderThen(int $days): bool
	{
		$qb = $this->entityManager->createQueryBuilder()
			->update('App\User\Domain\User', 'u')
			->set('u.status.value', ':deleted_status')
			->where('u.status.value = :inactive_status')
			->andWhere('DATE_DIFF(CURRENT_DATE(), u.lastLogin) > :days')
			->setParameter('deleted_status', UserStatus::delete()->getValue())
			->setParameter('inactive_status', UserStatus::deactive()->getValue())
			->setParameter('days', $days)
			->getQuery()->execute();

		return $qb;
	}
}
