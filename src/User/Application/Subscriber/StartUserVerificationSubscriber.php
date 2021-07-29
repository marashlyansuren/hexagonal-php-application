<?php

namespace App\User\Application\Subscriber;

use App\User\Application\Port\In\UserVerificationCommand;
use App\User\Application\Port\In\UserVerificationUseCase;
use App\User\Domain\Event\UserRegisteredEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StartUserVerificationSubscriber implements EventSubscriberInterface
{
	private UserVerificationUseCase $userVerificationUseCase;

	/**
	 * StartUserVerificationSubscriber constructor.
	 *
	 * @param UserVerificationUseCase $userVerificationUseCase
	 */
	public function __construct(UserVerificationUseCase $userVerificationUseCase)
	{
		$this->userVerificationUseCase = $userVerificationUseCase;
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
//        $this->userVerificationUseCase->startVerification(
//            new UserVerificationCommand($userRegisteredEvent->getUser())
//        );
	}
}
