<?php

namespace App\Common;

interface DateTimeGeneratorInterface
{
	/**
	 * @return \DateTimeImmutable
	 */
	public function getCurrentDateTimeImmutable(): \DateTimeImmutable;
}
