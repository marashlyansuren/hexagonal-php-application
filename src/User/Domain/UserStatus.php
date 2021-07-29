<?php

namespace App\User\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserStatus
 *
 * @package App\User\Domain
 *
 * @ORM\Embeddable
 */
class UserStatus
{
	private const USER_STATUS_ACTIVE   = 0;
	private const USER_STATUS_INACTIVE = 1;
	private const USER_STATUS_DELETED  = 2;

	/**
	 * @ORM\Column(type="smallint", name="status")
	 */
	private int $value;

	/**
	 * UserStatus constructor.
	 *
	 * @param int $value
	 */
	private function __construct(int $value)
	{
		$this->value = $value;
	}

	/**
	 * @return int
	 */
	public function getValue(): int
	{
		return $this->value;
	}

	public function toString(): string
	{
		switch ($this->value) {
			case self::USER_STATUS_INACTIVE:
				return "inactive";
			case self::USER_STATUS_DELETED:
				return "deleted";
		}

		return "active";
	}

	/**
	 * @return UserStatus
	 */
	public static function active(): UserStatus
	{
		return new UserStatus(self::USER_STATUS_ACTIVE);
	}

	/**
	 * @return UserStatus
	 */
	public static function deactive(): UserStatus
	{
		return new UserStatus(self::USER_STATUS_INACTIVE);
	}

	/**
	 * @return UserStatus
	 */
	public static function delete(): UserStatus
	{
		return new UserStatus(self::USER_STATUS_DELETED);
	}
}
