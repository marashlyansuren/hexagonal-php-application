<?php

namespace App\Common\Implementation;

use App\Common\UuidGeneratorInterface;
use App\Common\UuidInterface;
use Symfony\Component\Uid\Uuid;

class UuidGenerator implements UuidGeneratorInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getUuid(): UuidInterface
	{
		return new \App\Common\Uuid(Uuid::v4());
	}

	/**
	 * {@inheritDoc}
	 */
	public function fromString(string $uuid): UuidInterface
	{
		return new \App\Common\Uuid(Uuid::fromString($uuid));
	}
}
