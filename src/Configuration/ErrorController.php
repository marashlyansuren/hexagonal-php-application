<?php

namespace App\Configuration;

use App\Common\GeneralException;
use App\User\Adapter\In\Web\Exception\ValidationException;
use App\User\Application\Exception\UserException;
use App\User\Application\Exception\UserNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ErrorController
{
	private const ERROR_MAP = [
		ValidationException::class => [
			"code" => "VALIDATION_FAILED",
			"message" => "Validation failed"
		],
		UserException::class => [
			"code" => "USER_INVALID_DATA",
			"message" => "User invalid data provided"
		],
		UserNotFoundException::class => [
			"code" => "HTTP_NOT_FOUND",
			"message" => "No user with such email."
		],
		HttpException::class => [
			"code" => "INVALID_HTTP_REQUEST",
			"message" => "Invalid http request "
		],
		\Exception::class => [
			"code" => "SYSTEM_ERROR",
			"message" => "System error"
		],
		\Throwable::class => [
			"code" => "SYSTEM_ERROR",
			"message" => "System error"
		]
	];

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * ErrorController constructor.
	 *
	 * @param LoggerInterface $logger
	 */
	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	/**
	 * @TODO make this simple
	 *
	 * @param \Throwable $exception
	 *
	 * @return JsonResponse
	 */
	public function show(\Throwable $exception)
	{
		$code = $exception->getCode();
		if (method_exists($exception, "getStatusCode")) {
			$code = $exception->getStatusCode();
		}

		if (! $code) {
			$code = Response::HTTP_INTERNAL_SERVER_ERROR;
		}

		$body = [
			"errors" => []
		];

		if (isset(self::ERROR_MAP[get_class($exception)])) {
			$body["code"]    = self::ERROR_MAP[get_class($exception)]["code"];
			$body["message"] = self::ERROR_MAP[get_class($exception)]["message"];
		}

		if ($exception instanceof ValidationException) {
			$body["errors"] = array_merge($body["errors"], $exception->getErrors());
		} elseif ($exception instanceof GeneralException) {
			$body["errors"][] = $exception->getMessage();
		} elseif ($exception instanceof HttpException) {
			$body["code"]     = self::ERROR_MAP[HttpException::class]["code"];
			$body["message"]  = self::ERROR_MAP[HttpException::class]["message"];
			$body["errors"][] = $exception->getMessage();
		} else {
			$this->logger->error(
				$exception->getMessage(),
				[
					"trace" => $exception->getTrace()
				]
			);
			$code            = Response::HTTP_INTERNAL_SERVER_ERROR;
			$body["code"]    = self::ERROR_MAP[\Exception::class]["code"];
			$body["message"] = self::ERROR_MAP[\Exception::class]["message"];
		}

		$response = new JsonResponse(
			$body,
			$code
		);

		$response->headers->set('Content-Type', 'application/json; charset=UTF-8');

		return $response;
	}
}
