<?php

namespace App\Configuration\Subscriber;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class FinishRequestSubscriber
 *
 * @package App\Configuration\Events
 */
class FlushDatabaseChangesHttpResponseSubscriber implements EventSubscriberInterface
{
	private EntityManagerInterface $entityManager;

	/**
	 * FinishRequestSubscriber constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return array<string, array<int, array<int, int|string>>>
	 */
	public static function getSubscribedEvents()
	{
		return [
			KernelEvents::RESPONSE => [
				['processDatabaseFlush', 10],
			],
		];
	}

	public function processDatabaseFlush(ResponseEvent $event): void
	{
		if (
			in_array(
				$event->getResponse()->getStatusCode(),
				[
					Response::HTTP_OK,
					Response::HTTP_CREATED,
				]
			)
		) {
			$this->entityManager->flush();
		}
	}
}
