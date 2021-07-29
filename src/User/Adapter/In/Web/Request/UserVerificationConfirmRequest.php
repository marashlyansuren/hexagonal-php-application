<?php

namespace App\User\Adapter\In\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserVerificationConfirmRequest
{
	/**
	 * @Assert\NotBlank(
	 *     message="The status should not be blank."
	 * )
	 * @Assert\EqualTo(
	 *     value="confirmed",
	 *     message="The status should be equal 'confirmed'."
	 * )
	 */
	public string $status;
}
