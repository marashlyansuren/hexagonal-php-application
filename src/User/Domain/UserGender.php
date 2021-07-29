<?php

namespace App\User\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserGender
 *
 * @package App\User\Domain
 *
 * @ORM\Embeddable
 */
class UserGender
{
	private const USER_GENDER_NOT_PROVIDED = 0;
	private const USER_GENDER_MALE         = 1;
	private const USER_GENDER_FEMALE       = 2;
	private const USER_GENDER_OTHER        = 3;

	/**
	 * @ORM\Column(type="smallint", name="gender")
	 */
	private int $value;

	/**
	 * UserType constructor.
	 *
	 * @param int $value
	 */
	private function __construct(int $value)
	{
		$this->value = $value;
	}

	public function getValue(): int
	{
		return $this->value;
	}

	public function toString(): string
	{
		switch ($this->value) {
			case self::USER_GENDER_MALE:
				return "male";
			case self::USER_GENDER_FEMALE:
				return "female";
			case self::USER_GENDER_OTHER:
				return "other";
		}

		return "not provided";
	}

	public function isNotProvided(): bool
	{
		return $this->value === 0;
	}

	public static function fromString(string $genderString): self
	{
		switch ($genderString) {
			case "male":
				return self::male();
			case "female":
				return self::female();
			case "other":
				return self::other();
			default:
				throw new \RuntimeException("Invalid gender type provided");
		}
	}

	public static function notProvided(): UserGender
	{
		return new UserGender(self::USER_GENDER_NOT_PROVIDED);
	}

	public static function male(): UserGender
	{
		return new UserGender(self::USER_GENDER_MALE);
	}

	public static function female(): UserGender
	{
		return new UserGender(self::USER_GENDER_FEMALE);
	}

	public static function other(): UserGender
	{
		return new UserGender(self::USER_GENDER_OTHER);
	}
}
