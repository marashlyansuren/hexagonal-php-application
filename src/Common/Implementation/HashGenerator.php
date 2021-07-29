<?php

namespace App\Common\Implementation;

use App\Common\HashGeneratorInterface;

class HashGenerator implements HashGeneratorInterface
{
	/**
	 * @var UuidGenerator
	 */
	private UuidGenerator $uuidGenerator;

	/**
	 * @var PasswordEncoder
	 */
	private PasswordEncoder $passwordEncoder;

	/**
	 * HashGenerator constructor.
	 *
	 * @param UuidGenerator   $uuidGenerator
	 * @param PasswordEncoder $passwordEncoder
	 */
	public function __construct(UuidGenerator $uuidGenerator, PasswordEncoder $passwordEncoder)
	{
		$this->uuidGenerator   = $uuidGenerator;
		$this->passwordEncoder = $passwordEncoder;
	}

	public function createRandomHash(): string
	{
		return base64_encode($this->passwordEncoder->encodePassword($this->uuidGenerator->getUuid()->toString()));
	}
}
