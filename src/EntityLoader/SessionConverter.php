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
use Arachne\EntityLoader\FilterInInterface;
use Arachne\EntityLoader\FilterOutInterface;
use Nette\Application\BadRequestException;
use Nette\Http\Session;
use Nette\Object;
use Nette\Utils\Random;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class SessionConverter extends Object implements FilterInInterface, FilterOutInterface
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
	 * @param mixed $value
	 * @return SessionEntityInterface
	 * @throws BadRequestException
	 */
	public function filterIn($value)
	{
		return $this->session->getSection('Arachne.SessionConverter')->$value;
	}

	/**
	 * @param SessionEntityInterface $entity
	 * @return string
	 */
	public function filterOut($value)
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
