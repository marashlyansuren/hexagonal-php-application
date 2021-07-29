<?php

namespace App\User\Adapter\In\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserForgotPasswordResetRequest
{
	/**
	 * @Assert\NotBlank(
	 *     message="The password should not be blank."
	 * )
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 50,
	 *      minMessage = "The password must be at least {{ limit }} characters long",
	 *      maxMessage = "The password cannot be longer than {{ limit }} characters"
	 * )
	 */
	public string $password;
}
