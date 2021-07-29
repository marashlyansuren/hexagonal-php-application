<?php

namespace App\User\Adapter\In\Web\Controller;

use App\Configuration\ApplicationController;
use App\User\Adapter\In\Web\Response\UserResponseMapper;
use App\User\Application\Port\In\UserDeactivateCommand;
use App\User\Application\Port\In\UserDeactivationUseCase;
use Symfony\Component\Routing\Annotation\Route;

class UserDeactivationController extends ApplicationController
{
	private UserResponseMapper $userResponseMapper;

	private UserDeactivationUseCase $userDeactivationUseCase;

	/**
	 * UserController constructor.
	 *
	 * @param UserResponseMapper      $userResponseMapper
	 * @param UserDeactivationUseCase $userDeactivationUseCase
	 */
	public function __construct(
		UserResponseMapper $userResponseMapper,
		UserDeactivationUseCase $userDeactivationUseCase
	) {
		$this->userResponseMapper      = $userResponseMapper;
		$this->userDeactivationUseCase = $userDeactivationUseCase;
	}

	/**
	 * @Route(
	 *     "/users/me",
	 *     methods={"DELETE"}
	 * )
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function delete()
	{
		$authenticatedUser = $this->getAuthenticatedUser();

		$user = $this->userDeactivationUseCase->delete(new UserDeactivateCommand($authenticatedUser));

		return $this->jsonResponse(
			$this->userResponseMapper->mapFromUserDomainEntity($user)
		);
	}
}