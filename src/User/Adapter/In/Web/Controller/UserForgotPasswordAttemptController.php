<?php

namespace App\User\Adapter\In\Web\Controller;

use App\Configuration\ApplicationController;
use App\User\Adapter\In\Web\Request\UserForgotPasswordAttemptRequest;
use App\User\Adapter\In\Web\Request\UserForgotPasswordAttemptRequestMapper;
use App\User\Adapter\In\Web\Response\UserForgotPasswordAttemptResponseMapper;
use App\User\Adapter\In\Web\Request\UserForgotPasswordResetRequest;
use App\User\Application\Port\In\UserForgotPasswordUseCase;
use App\User\Application\Port\In\UserResetPasswordUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserForgotPasswordAttemptController extends ApplicationController
{
	private UserForgotPasswordAttemptRequestMapper $userForgetPasswordRequestMapper;

	private UserForgotPasswordUseCase $userForgotPasswordUseCase;

	private UserResetPasswordUseCase $userResetPasswordUseCase;

	private UserForgotPasswordAttemptResponseMapper $userForgetPasswordResponseMapper;

	/**
	 * UserForgotPasswordAttemptController constructor.
	 *
	 * @param UserForgotPasswordAttemptRequestMapper  $userForgetPasswordRequestMapper
	 * @param UserForgotPasswordUseCase               $userForgotPasswordUseCase
	 * @param UserResetPasswordUseCase                $userResetPasswordUseCase
	 * @param UserForgotPasswordAttemptResponseMapper $userForgetPasswordResponseMapper
	 */
	public function __construct(
		UserForgotPasswordAttemptRequestMapper $userForgetPasswordRequestMapper,
		UserForgotPasswordUseCase $userForgotPasswordUseCase,
		UserResetPasswordUseCase $userResetPasswordUseCase,
		UserForgotPasswordAttemptResponseMapper $userForgetPasswordResponseMapper
	) {
		$this->userForgetPasswordRequestMapper  = $userForgetPasswordRequestMapper;
		$this->userForgotPasswordUseCase        = $userForgotPasswordUseCase;
		$this->userResetPasswordUseCase         = $userResetPasswordUseCase;
		$this->userForgetPasswordResponseMapper = $userForgetPasswordResponseMapper;
	}

	/**
	 * @Route(
	 *     "/forgot-password-attempts",
	 *     methods={"POST"}
	 * )
	 *
	 * @param UserForgotPasswordAttemptRequest $userForgetPasswordAttemptRequest
	 *
	 * @return Response
	 */
	public function start(UserForgotPasswordAttemptRequest $userForgetPasswordAttemptRequest)
	{
		$userForgotPasswordAttempt = $this->userForgotPasswordUseCase->sendNotification(
			$this->userForgetPasswordRequestMapper->mapToUserForgotPasswordNotificationCommand($userForgetPasswordAttemptRequest)
		);

		return $this->created(
			$this->userForgetPasswordResponseMapper->mapFromDomain($userForgotPasswordAttempt)
		);
	}

	/**
	 * @Route(
	 *     "/forgot-password-attempts/{token}",
	 *     methods={"PUT"}
	 * )
	 *
	 * @param string                         $token
	 * @param UserForgotPasswordResetRequest $userForgotPasswordResetRequest
	 *
	 * @return Response
	 * @throws \App\User\Application\Exception\UserForgotPasswordException
	 */
	public function reset(string $token, UserForgotPasswordResetRequest $userForgotPasswordResetRequest)
	{
		$userForgotPasswordAttempt = $this->userResetPasswordUseCase->reset(
			$this->userForgetPasswordRequestMapper->mapToUserResetPasswordCommand(
				$token,
				$userForgotPasswordResetRequest
			)
		);

		return $this->jsonResponse(
			$this->userForgetPasswordResponseMapper->mapFromDomain($userForgotPasswordAttempt)
		);
	}
}
