<?php

namespace App\Configuration;

use App\Common\ResponseEntity;
use App\User\Adapter\In\Web\Exception\ValidationException;
use App\User\Adapter\In\Web\Request\UserUpdateRequest;
use App\User\Domain\User;
use Hateoas\Configuration\Route;
use Hateoas\HateoasBuilder;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\UrlGenerator\SymfonyUrlGenerator;
use JMS\Serializer\SerializationContext;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends AbstractController
{
	protected function getAuthenticatedUser(): User
	{
		/**
		 * @var User $authenticatedUser
		 */
		$authenticatedUser = parent::getUser();
		if (! $authenticatedUser instanceof User) {
			//@todo make this 401
			throw new \RuntimeException("There is no logged in user");
		}
		return $authenticatedUser;
	}

	/**
	 * @param Request $request
	 *
	 * @return int|null
	 */
	protected function getPage(Request $request): ?int
	{
		return $request->get('page');
	}

	/**
	 * @param Request $request
	 *
	 * @return int|null
	 */
	protected function getLimit(Request $request): ?int
	{
		return $request->get('limit');
	}

	protected function created(ResponseEntity $entity): Response
	{
		return $this->jsonResponse($entity, Response::HTTP_CREATED);
	}

	protected function jsonResponse(ResponseEntity $entity, int $status = Response::HTTP_OK): Response
	{
		return new JsonResponse(
			$this->serialize($entity),
			$status,
			[],
			true
		);
	}

	protected function jsonOkResponseCollection(ResponseEntity ...$entities): Response
	{
		$collection = new CollectionRepresentation($entities);

		return new JsonResponse(
			$this->serialize($collection),
			Response::HTTP_OK,
			[],
			true
		);
	}

	/**
	 * @param AdapterInterface $pagerAdapter
	 * @param callable         $callable
	 * @param string           $route
	 * @param mixed[]          $params
	 * @param int|null         $page
	 * @param int|null         $limit
	 *
	 * @return Response
	 */
	protected function jsonOkResponsePaginatedCollection(
		AdapterInterface $pagerAdapter,
		callable $callable,
		string $route,
		array $params = [],
		?int $page = 1,
		?int $limit = 10
	): Response {
		if (is_null($page)) {
			$page = 1;
		}

		if (is_null($limit)) {
			$limit = 10;
		}

		$hateoas = HateoasBuilder::create()
			->setUrlGenerator(null, new SymfonyUrlGenerator($this->container->get('router')))
			->build();
		$context = new SerializationContext();
		$context->setSerializeNull(true);

		$pagerfantaFactory = new PagerfantaFactory(); // you can pass the page,
		$pager             = new Pagerfanta($pagerAdapter);
		$pager->setMaxPerPage($limit);
		$pager->setCurrentPage($page);

		// and limit parameters name
		$paginatedCollection = $pagerfantaFactory->createRepresentation(
			$pager,
			new Route($route, $params),
			new CollectionRepresentation(array_map($callable, (array) $pager->getCurrentPageResults()))
		);

		return new JsonResponse(
			$hateoas->serialize($paginatedCollection, 'json', $context),
			Response::HTTP_OK,
			[],
			true
		);
	}

	/**
	 * @param AdapterInterface $pagerAdapter
	 * @param int|null         $page
	 * @param int|null         $limit
	 *
	 * @return mixed[]
	 */
	protected function getPaginationCurrentResult(AdapterInterface $pagerAdapter, ?int $page = 1, ?int $limit = 10): array
	{
		if (is_null($page)) {
			$page = 1;
		}
		if (is_null($limit)) {
			$limit = 10;
		}

		$pager = new Pagerfanta($pagerAdapter);
		$pager->setMaxPerPage($limit);
		$pager->setCurrentPage($page);

		return (array) $pager->getCurrentPageResults();
	}

	/**
	 * @param mixed $data
	 *
	 * @return string
	 */
	private function serialize($data)
	{
		$hateoas = HateoasBuilder::create()->build();
		$context = new SerializationContext();
		$context->setSerializeNull(true);

		return $hateoas->serialize($data, 'json', $context);
	}
}
