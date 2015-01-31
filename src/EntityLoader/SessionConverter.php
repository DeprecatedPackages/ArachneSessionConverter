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
	public function filterOut($type, $value)
	{
		if (!$value instanceof SessionEntityInterface) {
			throw new InvalidArgumentException("Given entity is not instance of 'Arachne\SessionConverter\EntityLoader\SessionEntityInterface'.");
		}
		if (!$value->getSessionKey()) {
			do {
				$key = Random::generate(10);
			} while (isset($this->session->getSection('Arachne.SessionConverter')->$key));
			$value->setSessionKey($key);
			$this->session->getSection('Arachne.SessionConverter')->$key = $value;
		}
		return $value->getSessionKey();
	}

}
