<?php

namespace App\User\Adapter\In\Web\Controller;

use App\Configuration\ApplicationController;
use App\User\Adapter\In\Web\Request\UserVerificationConfirmRequest;
use App\User\Adapter\In\Web\Request\UserVerificationRequestMapper;
use App\User\Adapter\In\Web\Response\UserVerificationResponseMapper;
use App\User\Application\Port\In\UserVerificationConfirmationUseCase;
use App\User\Application\Port\In\UserVerificationUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserVerificationController extends ApplicationController
{
	private UserVerificationUseCase $userVerificationUseCase;

	private UserVerificationConfirmationUseCase $userVerificationConfirmationUseCase;

	private UserVerificationRequestMapper $userVerificationRequestMapper;

	private UserVerificationResponseMapper $userVerificationResponseMapper;

	/**
	 * UserVerificationController constructor.
	 *
	 * @param UserVerificationUseCase             $userVerificationUseCase
	 * @param UserVerificationConfirmationUseCase $userVerificationConfirmationUseCase
	 * @param UserVerificationRequestMapper       $userVerificationRequestMapper
	 * @param UserVerificationResponseMapper      $userVerificationResponseMapper
	 */
	public function __construct(
		UserVerificationUseCase $userVerificationUseCase,
		UserVerificationConfirmationUseCase $userVerificationConfirmationUseCase,
		UserVerificationRequestMapper $userVerificationRequestMapper,
		UserVerificationResponseMapper $userVerificationResponseMapper
	) {
		$this->userVerificationUseCase             = $userVerificationUseCase;
		$this->userVerificationConfirmationUseCase = $userVerificationConfirmationUseCase;
		$this->userVerificationRequestMapper       = $userVerificationRequestMapper;
		$this->userVerificationResponseMapper      = $userVerificationResponseMapper;
	}

	/**
	 * @Route(
	 *     "/users/me/verifications",
	 *     methods={"POST"}
	 * )
	 *
	 * @return Response
	 * @throws \App\User\Application\Exception\UserNotFoundException
	 */
	public function start()
	{
		$userVerification = $this->userVerificationUseCase->startVerification(
			$this->userVerificationRequestMapper->mapToUserVerificationCommand($this->getAuthenticatedUser())
		);

		return $this->created(
			$this->userVerificationResponseMapper->mapFromDomain($userVerification)
		);
	}

	/**
	 * @Route(
	 *     "/users/me/verifications/{token}",
	 *     methods={"PUT"}
	 * )
	 *
	 * @param string                         $token
	 * @param UserVerificationConfirmRequest $userVerificationConfirmRequest
	 *
	 * @return Response
	 * @throws \App\User\Application\Exception\UserNotFoundException
	 * @throws \App\User\Application\Exception\UserVerificationException
	 */
	public function confirm(string $token, UserVerificationConfirmRequest $userVerificationConfirmRequest)
	{
		$userVerification = $this->userVerificationConfirmationUseCase->confirm(
			$this->userVerificationRequestMapper->mapToUserVerificationConfirmCommand(
				$this->getAuthenticatedUser(),
				$token
			)
		);

		return $this->jsonResponse(
			$this->userVerificationResponseMapper->mapFromDomain($userVerification)
		);
	}
}
