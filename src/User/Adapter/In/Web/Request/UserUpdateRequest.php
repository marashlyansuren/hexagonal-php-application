<?php

namespace App\User\Adapter\In\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateRequest
{

	public const GENDER_TYPES = ["male", "female", "other"];

	/**
	 * @Assert\Length(
	 *      min = 4,
	 *      max = 75,
	 *      minMessage = "The full name must be at least {{ limit }} characters long",
	 *      maxMessage = "The full name cannot be longer than {{ limit }} characters"
	 * )
	 */
	public ?string $fullName = null;

	/**
	 * @Assert\Length(
	 *      min = 4,
	 *      max = 75,
	 *      minMessage = "The display name must be at least {{ limit }} characters long",
	 *      maxMessage = "The display name cannot be longer than {{ limit }} characters"
	 * )
	 */
	public ?string $displayName = null;

	/**
	 * @Assert\Date(
	 *      message = "This value {{ value }} is not a valid date, it should be Y-m-d"
	 * )
	 */
	public ?string $birthday = null;

	/**
	 * @Assert\Choice(choices=UserUpdateRequest::GENDER_TYPES, message="{{ value }} is not valid user type, valid
	 *                                                         values are {{ choices }}")
	 */
	public ?string $gender = null;

	/**
	 * @Assert\Length(
	 *      min = 40,
	 *      max = 41,
	 *      minMessage = "The profile image name must be at least {{ limit }} characters long",
	 *      maxMessage = "The profile image name cannot be longer than {{ limit }} characters"
	 * )
	 */
	public ?string $profileImage = null;

	/**
	* @Assert\Email(
	*      message = "The '{{ value }}' is not a valid email."
	* )
	* @Assert\Length(
	*      max = 255,
	*      maxMessage = "The email cannot be longer than {{ limit }} characters"
	* )
	*/
	public ?string $email = null;

	/**
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 30,
	 *      minMessage = "The password must be at least {{ limit }} characters long",
	 *      maxMessage = "The password cannot be longer than {{ limit }} characters"
	 * )
	 */
	public ?string $passwordOld = null;

	/**
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 30,
	 *      minMessage = "The password must be at least {{ limit }} characters long",
	 *      maxMessage = "The password cannot be longer than {{ limit }} characters"
	 * )
	 */
	public ?string $password = null;
}
