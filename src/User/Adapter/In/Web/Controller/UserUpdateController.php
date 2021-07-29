<?php

namespace App\User\Adapter\In\Web\Controller;

use App\Configuration\ApplicationController;
use App\User\Adapter\In\Web\Request\UserUpdateRequest;
use App\User\Adapter\In\Web\Request\UserUpdateRequestMapper;
use App\User\Adapter\In\Web\Response\UserResponseMapper;
use App\User\Application\Port\In\UserUpdateUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserUpdateController extends ApplicationController
{
	private UserUpdateUseCase $userUpdateUseCase;

	private UserUpdateRequestMapper $userUpdateRequestMapper;

	private UserResponseMapper $userResponseMapper;

	/**
	 * UserUpdateController constructor.
	 *
	 * @param UserUpdateUseCase       $userUpdateUseCase
	 * @param UserUpdateRequestMapper $userUpdateRequestMapper
	 * @param UserResponseMapper      $userResponseMapper
	 */
	public function __construct(
		UserUpdateUseCase $userUpdateUseCase,
		UserUpdateRequestMapper $userUpdateRequestMapper,
		UserResponseMapper $userResponseMapper
	) {
		$this->userUpdateUseCase       = $userUpdateUseCase;
		$this->userUpdateRequestMapper = $userUpdateRequestMapper;
		$this->userResponseMapper      = $userResponseMapper;
	}

	/**
	 * @Route(
	 *     "/users/me",
	 *     methods={"PATCH"}
	 * )
	 *
	 * @param UserUpdateRequest $userUpdateRequest
	 *
	 * @return Response
	 * @throws \Exception
	 */
	public function update(UserUpdateRequest $userUpdateRequest)
	{
		$user = $this->userUpdateUseCase->update(
			$this->userUpdateRequestMapper->mapToUserUpdateCommand(
				$this->getAuthenticatedUser(),
				$userUpdateRequest
			)
		);

		return $this->jsonResponse(
			$this->userResponseMapper->mapFromUserDomainEntity(
				$user
			)
		);
	}
}