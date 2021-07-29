<?php

namespace App\User\Application\Exception;

use Symfony\Component\HttpFoundation\Response;

class UserForgotPasswordException extends UserException
{
	public static function notFoundByTokenAndStatus(string $token, int $status): self
	{
		return new self(
			sprintf("User forgot password attempt not found token: %s and status id: %d", $token, $status),
			Response::HTTP_BAD_REQUEST
		);
	}
}
