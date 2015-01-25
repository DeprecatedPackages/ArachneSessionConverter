<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\SessionConverter\EntityLoader;

use Arachne\SessionConverter\EntityLoader\SessionEntityInterface;
use Arachne\SessionConverter\Exception\InvalidArgumentException;
use Arachne\EntityLoader\ConverterInterface;
use Nette\Application\BadRequestException;
use Nette\Http\Session;
use Nette\Object;
use Nette\Utils\Random;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class SessionConverter extends Object implements ConverterInterface
{

	/** @var Session */
	protected $session;

	/**
	 * @param Session $session
	 */
	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	/**
	 * @param string $type
	 * @param mixed $value
	 * @return SessionEntityInterface
	 * @throws BadRequestException
	 */
	public function filterIn($type, $value)
	{
		$entity = $this->session->getSection('Arachne.SessionConverter')->$value;
		if (!$entity instanceof $type) {
			throw new BadRequestException("Desired entity of type '$type' could not be found.");
		}
		return $entity;
	}

	/**
	 * @param string $type
	 * @param SessionEntityInterface $entity
	 * @return string
	 */
	public function filterOut($type, $entity)
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
