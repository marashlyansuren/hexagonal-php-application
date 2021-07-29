<?php

namespace App\Common;

abstract class AbstractEvent implements EventInterface
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var \DateTimeImmutable
	 */
	protected $createdAt;

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getCreatedAt(): \DateTimeImmutable
	{
		return $this->createdAt;
	}
}
