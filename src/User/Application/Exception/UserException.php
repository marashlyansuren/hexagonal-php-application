<?php

namespace App\User\Application\Exception;

use App\Common\GeneralException;
use Symfony\Component\HttpFoundation\Response;

class UserException extends GeneralException
{
	public static function emailAlreadyExistsException(string $email): self
	{
		return new self(
			sprintf("%s already exists", $email),
			Response::HTTP_BAD_REQUEST
		);
	}

	public static function passwordNotExistsException(string $password): self
	{
		return new self(
			sprintf("%s invalid password", $password),
			Response::HTTP_BAD_REQUEST
		);
	}
}
