<?php

namespace App\User\Adapter\In\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterRequest
{
	/**
	 * @Assert\Type(
	 *      type="string",
	 *      message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Assert\NotBlank(
	 *     message="The email should not be blank."
	 * )
	 * @Assert\Email(
	 *      message = "The '{{ value }}' is not a valid email."
	 * )
	 * @Assert\Length(
	 *      max = 255,
	 *      maxMessage = "The password cannot be longer than {{ limit }} characters"
	 * )
	 */
	public $email;

	/**
	 * @Assert\Type(
	 *      type="string",
	 *      message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Assert\NotBlank(
	 *     message="The password should not be blank."
	 * )
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 30,
	 *      minMessage = "The password must be at least {{ limit }} characters long",
	 *      maxMessage = "The password cannot be longer than {{ limit }} characters"
	 * )
	 */
	public $password;

	/**
	 * @Assert\Type(
	 *      type="string",
	 *      message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Assert\NotBlank(
	 *     message="The full name should not be blank."
	 * )
	 * @Assert\Length(
	 *      min = 4,
	 *      max = 75,
	 *      minMessage = "The full name must be at least {{ limit }} characters long",
	 *      maxMessage = "The full name cannot be longer than {{ limit }} characters"
	 * )
	 */
	public $fullName;

	/**
	 * @Assert\Type(
	 *      type="string",
	 *      message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Assert\Length(
	 *      min = 3,
	 *      max = 75,
	 *      minMessage = "The display name must be at least {{ limit }} characters long",
	 *      maxMessage = "The display name cannot be longer than {{ limit }} characters"
	 * )
	 */
	public $displayName = null;
}
