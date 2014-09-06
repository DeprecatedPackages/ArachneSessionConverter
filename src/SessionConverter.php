<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\SessionConverter;

use Arachne\SessionConverter\Exception\InvalidArgumentException;
use Arachne\EntityLoader\IConverter;
use Nette\Application\BadRequestException;
use Nette\Http\Session;
use Nette\Object;
use Nette\Utils\Random;

/**
 * @author Jáchym Toušek
 */
class SessionConverter extends Object implements IConverter
{

	/** @var string[] */
	protected $types;

	/** @var Session */
	protected $session;

	/**
	 * @param string[] $types
	 * @param Session $session
	 */
	public function __construct(array $types, Session $session)
	{
		foreach ($types as $type) {
			if (!is_subclass_of($type, 'Arachne\SessionConverter\ISessionEntity')) {
				throw new InvalidArgumentException("Type '$type' does not implement Arachne\SessionConverter\ISessionEntity.");
			}
		}
		$this->types = $types;
		$this->session = $session;
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	public function canConvert($type)
	{
		return in_array($type, $this->types, TRUE);
	}

	/**
	 * @param string $type
	 * @param mixed $value
	 * @return object
	 * @throws BadRequestException
	 */
	public function parameterToEntity($type, $value)
	{
		$entity = $this->session->getSection('Arachne.SessionConverter')->$value;
		if (!$entity instanceof $type) {
			throw new BadRequestException("Desired entity of type '$type' could not be found.");
		}
		return $entity;
	}

	/**
	 * @param string $type
	 * @param object $entity
	 * @return string
	 */
	public function entityToParameter($type, $entity)
	{
		if (!$entity instanceof $type) {
			throw new InvalidArgumentException("Given entity is not instance of '$type'.");
		}
		if (!$entity->getSessionKey()) {
			$key = Random::generate(4);
			$entity->setSessionKey($key);
			$this->session->getSection('Arachne.SessionConverter')->$key = $entity;
		}
		return $entity->getSessionKey();
	}

}
