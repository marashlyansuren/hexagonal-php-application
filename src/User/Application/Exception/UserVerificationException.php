<?php

namespace App\User\Application\Exception;

use Symfony\Component\HttpFoundation\Response;

class UserVerificationException extends UserException
{
	public static function notFoundByIdAndUserId(string $id, string $userId): self
	{
		return new self(
			sprintf("User verification not found by id: %s and user id: %s", $id, $userId),
			Response::HTTP_BAD_REQUEST
		);
	}

	public static function notFoundByTokenUserIdAndStatus(string $token, string $userId, int $status): self
	{
		return new self(
			sprintf("User verification not found by token: %s, user id: %s and status %d", $token, $userId, $status),
			Response::HTTP_BAD_REQUEST
		);
	}

	public static function wrongConformationToken(string $token): self
	{
		return new self(
			sprintf("User verification failed, wrong token %s provided or it is not up-to-date", $token),
			Response::HTTP_BAD_REQUEST
		);
	}
}
