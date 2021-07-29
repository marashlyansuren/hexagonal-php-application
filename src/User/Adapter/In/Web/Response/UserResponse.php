<?php

namespace App\User\Adapter\In\Web\Response;

use App\Common\ResponseEntity;
use App\User\Domain\UserGender;
use App\User\Domain\UserStatus;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Class UserResponse
 *
 * @package App\User\Adapter\In\Web
 *
 * @Hateoas\Relation("self",         href = "expr('/users/' ~ object.getId())")
 * @Hateoas\Relation("verification", href = "expr('/users/' ~ object.getId() ~ '/verifications')")
 */
class UserResponse extends ResponseEntity
{
	private string $id;

	private string $email;

	private ?string $fullName;

	private ?string $displayName;

	private ?string $birthDay;

	private ?string $gender;

	private bool $verified;

	private string $status;

	protected string $createdAt;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id): void
	{
		$this->id = $id;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email): void
	{
		$this->email = $email;
	}

	/**
	 * @param string|null $fullName
	 */
	public function setFullName(?string $fullName): void
	{
		$this->fullName = $fullName;
	}

	/**
	 * @param string|null $displayName
	 */
	public function setDisplayName(?string $displayName): void
	{
		$this->displayName = $displayName;
	}

	/**
	 * @param \DateTimeImmutable|null $birthDay
	 */
	public function setBirthDay(?\DateTimeImmutable $birthDay): void
	{
		$this->birthDay = $birthDay ? $birthDay->format(ResponseEntity::DATE_FORMAT) : null;
	}

	/**
	 * @param UserGender $gender
	 */
	public function setGender(UserGender $gender): void
	{
		$this->gender = $gender->isNotProvided() ? null : $gender->toString();
	}

	/**
	 * @param UserStatus $status
	 */
	public function setStatus(UserStatus $status): void
	{
		$this->status = $status->toString();
	}

	/**
	 * @param \DateTimeImmutable $createdAt
	 */
	public function setCreatedAt(\DateTimeImmutable $createdAt): void
	{
		$this->createdAt = $createdAt->format(self::DATE_TIME_FORMAT);
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @return string|null
	 */
	public function getFullName(): ?string
	{
		return $this->fullName;
	}

	/**
	 * @return string
	 */
	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	/**
	 * @param bool $verified
	 */
	public function setVerified(bool $verified): void
	{
		$this->verified = $verified;
	}
}
