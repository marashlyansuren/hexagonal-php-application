<?php

namespace App\Common;

interface HashGeneratorInterface
{
	public function createRandomHash(): string;
}
