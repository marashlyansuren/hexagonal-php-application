<?php

namespace App\Common\Implementation;

use App\Common\DateTimeGeneratorInterface;

class DateTimeGenerator implements DateTimeGeneratorInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getCurrentDateTimeImmutable(): \DateTimeImmutable
	{
		return new \DateTimeImmutable("now");
	}
}
