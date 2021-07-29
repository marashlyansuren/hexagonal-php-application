<?php

namespace App\User\Domain;

use App\Common\UuidInterface;
use App\User\Application\Exception\UserVerificationException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_verification")
 */
class UserVerification
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="guid")
	 */
	private string $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\User\Domain\User")
	 * @ORM\JoinColumn(name="user_id",                     referencedColumnName="id")
	 */
	private User $user;

	/**
	 * @ORM\Column(unique=true)
	 */
	private string $token;

	/**
	 * @var                                                          UserVerificationStatus
	 * @ORM\Embedded(class="App\User\Domain\UserVerificationStatus", columnPrefix=false)
	 */
	private UserVerificationStatus $status;

	/**
	 * @ORM\Column(type="datetime_immutable", name="created_at")
	 */
	private \DateTimeImmutable $createdAt;

	/**
	 * @ORM\Column(type="datetime_immutable", name="updated_at", nullable=true)
	 */
	private \DateTimeImmutable $updatedAt;

	/**
	 * UserVerification constructor.
	 *
	 * @param UuidInterface      $id
	 * @param User               $user
	 * @param string             $token
	 * @param \DateTimeImmutable $createdAt
	 */
	public function __construct(UuidInterface $id, User $user, string $token, \DateTimeImmutable $createdAt)
	{
		$this->id        = $id->toString();
		$this->user      = $user;
		$this->token     = $token;
		$this->createdAt = $createdAt;

		$this->status = UserVerificationStatus::created();
	}

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}

	/**
	 * @TODO   remove this after email integration
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token;
	}

	/**
	 * @return UserVerificationStatus
	 */
	public function getStatus(): UserVerificationStatus
	{
		return $this->status;
	}

	/**
	 * @param UserVerificationStatus $status
	 */
	public function setStatus(UserVerificationStatus $status): void
	{
		$this->status = $status;
	}

	public function disable(): void
	{
		$this->status = UserVerificationStatus::disabled();
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getCreatedAt(): \DateTimeImmutable
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTimeImmutable $updatedAt
	 */
	public function confirm(\DateTimeImmutable $updatedAt): void
	{
		$this->status    = UserVerificationStatus::confirmed();
		$this->updatedAt = $updatedAt;
	}
}
