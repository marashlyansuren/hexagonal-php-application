<?php

namespace App\User\Adapter\In\Web\Controller;

use App\Configuration\ApplicationController;
use App\User\Adapter\In\Web\Request\UserRegisterRequest;
use App\User\Adapter\In\Web\Request\UserRegisterRequestMapper;
use App\User\Adapter\In\Web\Response\UserResponseMapper;
use App\User\Application\Port\In\UserRegistrationUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRegistrationController extends ApplicationController
{
	/**
	 * @var UserRegistrationUseCase
	 */
	private UserRegistrationUseCase $userRegistrationUseCase;

	/**
	 * @var UserResponseMapper
	 */
	private UserResponseMapper $userResponseMapper;

	private UserRegisterRequestMapper $userRegisterRequestMapper;

	/**
	 * UserRegistrationController constructor.
	 *
	 * @param UserRegistrationUseCase   $userRegistrationUseCase
	 * @param UserResponseMapper        $userResponseMapper
	 * @param UserRegisterRequestMapper $userRegisterRequestMapper
	 */
	public function __construct(
		UserRegistrationUseCase $userRegistrationUseCase,
		UserResponseMapper $userResponseMapper,
		UserRegisterRequestMapper $userRegisterRequestMapper
	) {
		$this->userRegistrationUseCase   = $userRegistrationUseCase;
		$this->userResponseMapper        = $userResponseMapper;
		$this->userRegisterRequestMapper = $userRegisterRequestMapper;
	}

	/**
	 * @Route(
	 *     "/users",
	 *     methods={"POST"}
	 * )
	 *
	 * @param UserRegisterRequest $userRegisterRequest
	 *
	 * @return Response
	 * @throws \App\User\Application\Exception\UserException
	 */
	public function register(UserRegisterRequest $userRegisterRequest)
	{
		$userRegisterCommand = $this->userRegisterRequestMapper->mapToUserRegisterCommand($userRegisterRequest);
		$user                = $this->userRegistrationUseCase->register($userRegisterCommand);

		return $this->created(
			$this->userResponseMapper->mapFromUserDomainEntity($user)
		);
	}
}
