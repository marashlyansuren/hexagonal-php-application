<?php

namespace App\User\Adapter\In\Web\Response;

use App\Common\ResponseEntity;
use App\User\Domain\UserVerificationStatus;

/**
 * Class UserVerificationResponse
 *
 * @package App\User\Adapter\In\Web
 */
class UserVerificationResponse extends ResponseEntity
{
	private string $status;

	/**
	 * @param UserVerificationStatus $domainStatus
	 */
	public function setStatus(UserVerificationStatus $domainStatus): void
	{
		$this->status = $domainStatus->toString();
	}
}
