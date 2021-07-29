<?php

namespace App\Common;

interface EventInterface
{
	/**
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @return \DateTimeImmutable
	 */
	public function getCreatedAt(): \DateTimeImmutable;
}
