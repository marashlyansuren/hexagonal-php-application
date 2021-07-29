<?php

namespace App\User\Application\Exception;

use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends UserException
{
	/**
	 * @var int
	 */
	protected $code = Response::HTTP_NOT_FOUND;

	public static function byId(string $id): self
	{
		return new self(sprintf("User not found by id: %s", $id));
	}

	public static function byEmail(string $email): self
	{
		return new self(sprintf("User not found by email: %s", $email));
	}
}
