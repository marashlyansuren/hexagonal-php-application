<?php

namespace App\User\Application\Port\Out;

use App\User\Application\Exception\UserNotFoundException;
use App\User\Domain\User;

interface LoadUserPort
{
	/**
	 * @param string $id
	 *
	 * @return User
	 * @throws UserNotFoundException
	 */
	public function getUserById(string $id): User;

	/**
	 * @param string $email
	 *
	 * @return User
	 * @throws UserNotFoundException
	 */
	public function getByEmail(string $email): User;

	/**
	 * @param string $email
	 *
	 * @return User|null
	 */
	public function findByEmail(string $email): ?User;

	/**
	 * @param int $days
	 *
	 * @return bool
	 */
	public function deleteInactiveUsersOlderThen(int $days): bool;
}
