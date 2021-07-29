<?php

namespace App\User\Adapter\In\Web\Exception;

use App\Common\GeneralException;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends GeneralException
{
	/**
	 * @var string[]
	 */
	protected array $errors;

	/**
	 * @param string[] $errors
	 *
	 * @return self
	 */
	public static function errors(array $errors): self
	{
		$validationException         = new self("Validation failed", Response::HTTP_BAD_REQUEST);
		$validationException->errors = $errors;

		return $validationException;
	}

	/**
	 * @return string[]
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}
