<?php

namespace App\User\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserVerificationStatus
 *
 * @package App\User\Domain
 *
 * @ORM\Embeddable
 */
class UserVerificationStatus
{
	private const USER_VERIFICATION_STATUS_CREATED   = 0;
	private const USER_VERIFICATION_STATUS_CONFIRMED = 1;
	private const USER_VERIFICATION_STATUS_DISABLED  = 2;
	private const USER_VERIFICATION_STATUS_EXPIRED   = 3;

	/**
	 * @var                         int
	 * @ORM\Column(type="smallint", name="status")
	 */
	private $value;

	/**
	 * UserType constructor.
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
			case self::USER_VERIFICATION_STATUS_CONFIRMED:
				return "confirmed";
			case self::USER_VERIFICATION_STATUS_DISABLED:
				return "disabled";
			case self::USER_VERIFICATION_STATUS_EXPIRED:
				return "expired";
		}

		return "created";
	}

	public static function fromInt(int $value): self
	{
		switch ($value) {
			case self::USER_VERIFICATION_STATUS_CREATED:
				return self::created();
			case self::USER_VERIFICATION_STATUS_CONFIRMED:
				return self::confirmed();
			case self::USER_VERIFICATION_STATUS_DISABLED:
				return self::disabled();
			case self::USER_VERIFICATION_STATUS_EXPIRED:
				return self::expired();
			default:
				throw new \RuntimeException("Invalid user verification status");
		}
	}

	public static function created(): self
	{
		return new self(self::USER_VERIFICATION_STATUS_CREATED);
	}

	public static function confirmed(): self
	{
		return new self(self::USER_VERIFICATION_STATUS_CONFIRMED);
	}

	public static function disabled(): self
	{
		return new self(self::USER_VERIFICATION_STATUS_DISABLED);
	}

	public static function expired(): self
	{
		return new self(self::USER_VERIFICATION_STATUS_EXPIRED);
	}
}
