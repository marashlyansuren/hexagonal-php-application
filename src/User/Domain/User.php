<?php

namespace App\User\Domain;

use App\Common\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserInterface used for authentication vs authorization
 *
 * @TODO think about decoupling from UserInterface
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="guid")
	 */
	private string $id;

	/**
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	private string $email;

	/**
	 * @ORM\Column(type="string")
	 */
	private string $password;

	/**
	 * @ORM\Column(type="string", name="full_name", nullable=true, length=75)
	 */
	private ?string $fullName = null;

	/**
	 * @ORM\Column(type="string", name="display_name", nullable=true, length=75)
	 */
	private ?string $displayName = null;

	/**
	 * @ORM\Column(type="datetime_immutable", name="birthday", nullable=true)
	 */
	private ?\DateTimeImmutable $birthday = null;

	/**
	 * @ORM\Embedded(class="App\User\Domain\UserGender", columnPrefix=false)
	 */
	private UserGender $gender;

	/**
	 * @ORM\Embedded(class="App\User\Domain\UserStatus", columnPrefix=false)
	 */
	private UserStatus $status;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private bool $verified;

	/**
	 * @ORM\Column(type="datetime_immutable", name="updated_at", nullable=true)
	 */
	private ?\DateTimeImmutable $updatedAt;

	/**
	 * @ORM\Column(type="datetime_immutable", name="created_at")
	 */
	private \DateTimeImmutable $createdAt;

	/**
	 * @ORM\Column(type="datetime_immutable", name="last_login", nullable=true)
	 */
	private \DateTimeImmutable $lastLogin;

	/**
	 * @TODO Decouple from user entity
	 *
	 * @var string[]
	 *
	 * @ORM\Column(type="json")
	 */
	private array $roles = [];

	/**
	 * User constructor.
	 *
	 * @param UuidInterface      $id
	 * @param string             $email
	 * @param string             $password
	 * @param \DateTimeImmutable $createdAt
	 */
	public function __construct(
		UuidInterface $id,
		string $email,
		string $password,
		\DateTimeImmutable $createdAt
	) {
		$this->id        = $id->toString();
		$this->email     = $email;
		$this->password  = $password;
		$this->createdAt = $createdAt;

		$this->verified = false;
		$this->status   = UserStatus::active();
		$this->gender   = UserGender::notProvided();
	}

	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	/**
	 * @return string|null
	 */
	public function getFullName(): ?string
	{
		return $this->fullName;
	}

	/**
	 * @return string|null
	 */
	public function getDisplayName(): ?string
	{
		return $this->displayName;
	}

	/**
	 * @return \DateTimeImmutable|null
	 */
	public function getBirthday(): ?\DateTimeImmutable
	{
		return $this->birthday;
	}

	/**
	 * @param \DateTimeImmutable|null $birthday
	 */
	public function setBirthday(?\DateTimeImmutable $birthday): void
	{
		$this->birthday = $birthday;
	}

	/**
	 * @return UserGender
	 */
	public function getGender(): UserGender
	{
		return $this->gender;
	}

	/**
	 * @param UserGender $gender
	 */
	public function setGender(UserGender $gender): void
	{
		$this->gender = $gender;
	}

	/**
	 * @return UserStatus
	 */
	public function getStatus(): UserStatus
	{
		return $this->status;
	}

	/**
	 * @return \DateTimeImmutable|null
	 */
	public function getUpdatedAt(): ?\DateTimeImmutable
	{
		return $this->updatedAt;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getCreatedAt(): \DateTimeImmutable
	{
		return $this->createdAt;
	}

	/**
	 * @param string $fullName
	 */
	public function setFullName(string $fullName): void
	{
		$this->fullName = $fullName;
	}

	/**
	 * @param string $displayName
	 */
	public function setDisplayName(string $displayName): void
	{
		$this->displayName = $displayName;
	}

	/**
	 * @param \DateTimeImmutable $lastLogin
	 */
	public function setLastLogin(\DateTimeImmutable $lastLogin): void
	{
		$this->lastLogin = $lastLogin;
	}

	/**
	 * @param \DateTimeImmutable|null $updatedAt
	 */
	public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
	{
		$this->updatedAt = $updatedAt;
	}

	/**
	 * @return bool
	 */
	public function isVerified(): bool
	{
		return $this->verified;
	}

	public function makeVerified(): void
	{
		$this->verified = true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getUsername(): string
	{
		return (string) $this->email;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRoles(): array
	{
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \Exception
	 */
	public function getSalt()
	{
		return null;
	}

	/**
	 * @param string $password
	 *
	 * @return void
	 */
	public function resetPassword(string $password)
	{
		$this->password = $password;
	}

	/**
	 * @return void
	 */
	public function deactivate(): void
	{
		$this->status = UserStatus::deactive();
	}

	/**
	 * @return void
	 */
	public function activate(): void
	{
		$this->status = UserStatus::active();
	}

	/**
	 * @return bool
	 */
	public function isDeactivated(): bool
	{
		return $this->getStatus()->getValue() == UserStatus::deactive()->getValue();
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return void
	 */
	public function eraseCredentials()
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}
}
