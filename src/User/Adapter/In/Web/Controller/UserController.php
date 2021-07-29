<?php

namespace App\User\Adapter\In\Web\Controller;

use App\Configuration\ApplicationController;
use App\User\Adapter\In\Web\Response\UserResponseMapper;
use App\User\Domain\User;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApplicationController
{
	private UserResponseMapper $userResponseMapper;

	/**
	 * UserController constructor.
	 *
	 * @param UserResponseMapper $userResponseMapper
	 */
	public function __construct(UserResponseMapper $userResponseMapper)
	{
		$this->userResponseMapper = $userResponseMapper;
	}

	/**
	 * @Route(
	 *     "/users/me",
	 *     methods={"GET"}
	 * )
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getMe()
	{
		/**
		 * @var User $authenticatedUser
		 */
		$authenticatedUser = parent::getUser();
		return $this->jsonResponse(
			$this->userResponseMapper->mapFromUserDomainEntity($authenticatedUser)
		);
	}
}
