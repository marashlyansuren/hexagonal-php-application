<?php

namespace App\Common;

use Symfony\Component\Security\Core\Exception\BadCredentialsException;

interface PasswordEncoderInterface
{
	/**
	 * Encodes the raw password.
	 *
	 * @param string $raw A raw password
	 *
	 * @return string The encoded password
	 *
	 * @throws BadCredentialsException   If the raw password is invalid, e.g. excessively long
	 */
	public function encodePassword(string $raw): string;

	/**
	 * Checks a raw password against an encoded password.
	 *
	 * @param string $encoded An encoded password
	 * @param string $raw     A raw password
	 *
	 * @return bool true if the password is valid, false otherwise
	 *
	 * @throws \InvalidArgumentException If the salt is invalid
	 */
	public function isPasswordValid(string $encoded, string $raw);
}
