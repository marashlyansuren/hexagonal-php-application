<?php

namespace App\Common;

interface EmailProviderInterface
{
	/**
	 * @param string $toEmail
	 * @param string $subject
	 * @param string $message
	 *
	 * @return mixed
	 */
	public function send(string $toEmail, string $subject, string $message);
}
