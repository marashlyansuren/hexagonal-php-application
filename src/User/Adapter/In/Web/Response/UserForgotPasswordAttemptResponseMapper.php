<?php

namespace App\User\Adapter\In\Web\Response;

use App\User\Domain\UserForgotPasswordAttempt;

class UserForgotPasswordAttemptResponseMapper
{
	public function mapFromDomain(UserForgotPasswordAttempt $userForgotPasswordAttempt): UserForgotPasswordAttemptResponse
	{
		$userForgotPasswordAttemptResponse = new UserForgotPasswordAttemptResponse();
		$userForgotPasswordAttemptResponse->setStatus($userForgotPasswordAttempt->getStatus());

		return $userForgotPasswordAttemptResponse;
	}
}
