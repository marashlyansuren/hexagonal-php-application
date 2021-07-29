<?php

namespace App\User\Adapter\In\Web\Response;

use App\Common\ResponseEntity;
use App\User\Domain\UserForgotPasswordAttemptStatus;

/**
 * Class UserForgotPasswordAttemptResponse
 *
 * @package App\User\Adapter\In\Web
 */
class UserForgotPasswordAttemptResponse extends ResponseEntity
{
	private string $status;

	/**
	 * @param UserForgotPasswordAttemptStatus $domainStatus
	 */
	public function setStatus(UserForgotPasswordAttemptStatus $domainStatus): void
	{
		$this->status = $domainStatus->toString();
	}
}
