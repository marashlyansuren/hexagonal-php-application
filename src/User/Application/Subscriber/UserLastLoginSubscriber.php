<?php

namespace App\User\Application\Subscriber;

use App\User\Application\Port\Out\LoadUserPort;
use App\User\Application\Port\In\UpdateUserLastLoginUseCase;
use App\User\Application\Port\In\UserLastLoginCommand;
use App\User\Domain\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserLastLoginSubscriber implements EventSubscriberInterface
{
	/**
	 * @var UpdateUserLastLoginUseCase
	 */
	private UpdateUserLastLoginUseCase $updateUserLastLoginUseCase;

	/**
	 * @var LoadUserPort
	 */
	private LoadUserPort $loadUserPort;

	/**
	 * AuthenticationSuccessSubscriber constructor.
	 *
	 * @param UpdateUserLastLoginUseCase $updateUserLastLoginUseCase
	 * @param LoadUserPort               $loadUserPort
	 */
	public function __construct(UpdateUserLastLoginUseCase $updateUserLastLoginUseCase, LoadUserPort $loadUserPort)
	{
		$this->updateUserLastLoginUseCase = $updateUserLastLoginUseCase;
		$this->loadUserPort               = $loadUserPort;
	}

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			InteractiveLoginEvent::class => "onUserLastLoginEvent"
		];
	}

	/**
	 * @param InteractiveLoginEvent $event
	 */
	public function onUserLastLoginEvent(InteractiveLoginEvent $event): void
	{
		$user = $event->getAuthenticationToken()->getUser();
		if (! $user instanceof User) {
			throw new \RuntimeException("Cannot get user from authentication token");
		}

		$this->updateUserLastLoginUseCase->lastLogin(new UserLastLoginCommand($user));
	}
}
