<?php

namespace App\User\Adapter\In\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserForgotPasswordAttemptRequest
{
	/**
	 * @Assert\NotBlank(
	 *     message="The email should not be blank."
	 * )
	 * @Assert\Email(
	 *      message = "The '{{ value }}' is not a valid email."
	 * )
	 */
	public string $email;
}
