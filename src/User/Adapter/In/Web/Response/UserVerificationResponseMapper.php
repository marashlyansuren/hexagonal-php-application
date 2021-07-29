<?php

namespace App\User\Adapter\In\Web\Response;

use App\User\Domain\UserVerification;

class UserVerificationResponseMapper
{
	public function mapFromDomain(UserVerification $userVerification): UserVerificationResponse
	{
		$userVerificationResponse = new UserVerificationResponse();
		$userVerificationResponse->setStatus($userVerification->getStatus());

		return $userVerificationResponse;
	}
}
