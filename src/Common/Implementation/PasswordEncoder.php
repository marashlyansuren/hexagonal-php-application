<?php

namespace App\Common\Implementation;

use App\Common\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\SodiumPasswordEncoder;

class PasswordEncoder implements PasswordEncoderInterface
{
	private SodiumPasswordEncoder $passwordEncoder;

	/**
	 * PasswordEncoder constructor.
	 *
	 * @param SodiumPasswordEncoder $nativePasswordEncoder
	 */
	public function __construct(SodiumPasswordEncoder $nativePasswordEncoder)
	{
		$this->passwordEncoder = $nativePasswordEncoder;
	}

	/**
	 * {@inheritdoc}
	 */
	public function encodePassword(string $raw): string
	{
		return $this->passwordEncoder->encodePassword($raw, null);
	}

	/**
	 * {@inheritdoc}
	 */
	public function isPasswordValid(string $encoded, string $raw): bool
	{
		return $this->passwordEncoder->isPasswordValid($encoded, $raw, null);
	}
}
