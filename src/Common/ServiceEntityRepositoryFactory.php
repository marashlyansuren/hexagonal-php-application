<?php

namespace App\Common;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ServiceEntityRepositoryFactory
{
	/**
	 * @var ManagerRegistry
	 */
	private $registry;

	/**
	 * ServiceEntityRepositoryFactory constructor.
	 *
	 * @param ManagerRegistry $registry
	 */
	public function __construct(ManagerRegistry $registry)
	{
		$this->registry = $registry;
	}

	public function create(string $entityClassName): ServiceEntityRepository
	{
		/** @phpstan-ignore-next-line */
		return new ServiceEntityRepository($this->registry, $entityClassName);
	}
}
