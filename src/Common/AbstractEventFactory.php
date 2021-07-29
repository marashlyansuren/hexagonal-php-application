<?php

namespace App\Common;

abstract class AbstractEventFactory
{
	/**
	 * @var DateTimeGeneratorInterface
	 */
	protected $dateTimeGenerator;

	/**
	 * UserRegisteredEventFactory constructor.
	 *
	 * @param DateTimeGeneratorInterface $dateTimeGenerator
	 */
	public function __construct(DateTimeGeneratorInterface $dateTimeGenerator)
	{
		$this->dateTimeGenerator = $dateTimeGenerator;
	}
}
