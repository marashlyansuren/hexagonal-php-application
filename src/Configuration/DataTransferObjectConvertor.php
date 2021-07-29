<?php

namespace App\Configuration;

use App\User\Adapter\In\Web\Exception\ValidationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DataTransferObjectConvertor implements ParamConverterInterface
{
	private DenormalizerInterface $serializer;

	private ValidatorInterface $validator;

	/**
	 * DataTransferObjectConvertor constructor.
	 *
	 * @param ValidatorInterface $validator
	 */
	public function __construct(ValidatorInterface $validator)
	{
		$normalizer       = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter(), null, new ReflectionExtractor());
		$this->serializer = new Serializer([$normalizer]);
		$this->validator  = $validator;
	}

	/**
	 * @param Request        $request
	 * @param ParamConverter $configuration
	 *
	 * @return bool
	 * @throws ExceptionInterface
	 * @throws \Exception
	 */
	public function apply(Request $request, ParamConverter $configuration)
	{
		$data  = json_decode((string) $request->getContent(), true);
		$class = $configuration->getClass();

		$dto = $this->serializer->denormalize($data, $class);

		$validationConstraints = $this->validator->validate($dto);
		if ($validationConstraints->count()) {
			$errors = [];
			foreach ($validationConstraints as $validationConstraint) {
				$errors[] = $validationConstraint->getMessage();
			}
			throw ValidationException::errors($errors);
		}

		$request->attributes->set($configuration->getName(), $dto);
		return true;
	}

	public function supports(ParamConverter $configuration)
	{
		return class_exists($configuration->getClass());
	}
}
