<?php

namespace App\User\Application\Subscriber;

use App\User\Domain\Event\UserRegisteredEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class QueueSendUserRegistrationEmailSubscriber implements EventSubscriberInterface
{
	private MessageBusInterface $messageBus;

	/**
	 * QueueSendUserRegistrationEmailSubscriber constructor.
	 *
	 * @param MessageBusInterface $messageBus
	 */
	public function __construct(MessageBusInterface $messageBus)
	{
		$this->messageBus = $messageBus;
	}

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			UserRegisteredEvent::class => "onUserRegisteredEvent"
		];
	}

	/**
	 * @param UserRegisteredEvent $userRegisteredEvent
	 */
	public function onUserRegisteredEvent(UserRegisteredEvent $userRegisteredEvent): void
	{
		$user = $userRegisteredEvent->getUser();

		//put in the queue registration email
//		$this->messageBus->dispatch(
//			new SendUserRegistrationEmailQueueMessage(
//				$user->getId(),
//				$user->getEmail(),
//				$user->getFullName()
//			)
//		);
	}
}
