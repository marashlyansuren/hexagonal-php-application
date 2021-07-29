<?php

namespace App\User\Adapter\In\Web\Request;

use App\Common\PasswordEncoderInterface;
use App\FileStorage\Application\Port\Out\LoadFilePreSignedUrlPort;
use App\FileStorage\Domain\FilePreSignedUrlType;
use App\User\Application\Port\In\UserUpdateCommand;
use App\User\Domain\User;
use App\User\Domain\UserGender;

class UserUpdateRequestMapper
{
	/**
	 * @param User              $user
	 * @param UserUpdateRequest $userUpdateRequest
	 *
	 * @return UserUpdateCommand
	 * @throws \Exception
	 */
	public function mapToUserUpdateCommand(User $user, UserUpdateRequest $userUpdateRequest): UserUpdateCommand
	{
		$userUpdateCommand = new UserUpdateCommand($user);

		if ($fullName = $userUpdateRequest->fullName) {
			$userUpdateCommand->setFullName($fullName);
		}

		if ($displayName = $userUpdateRequest->displayName) {
			$userUpdateCommand->setDisplayName($displayName);
		}

		if ($birthday = $userUpdateRequest->birthday) {
			$userUpdateCommand->setBirthday(
				new \DateTimeImmutable($birthday)
			);
		}

		if ($gender = $userUpdateRequest->gender) {
			$userUpdateCommand->setGender(
				UserGender::fromString($gender)
			);
		}


		if ($passwordOld = $userUpdateRequest->passwordOld) {
			$userUpdateCommand->setPassword($userUpdateRequest->password);
			$userUpdateCommand->setPasswordOld($userUpdateRequest->passwordOld);
		}

		return $userUpdateCommand;
	}
}
