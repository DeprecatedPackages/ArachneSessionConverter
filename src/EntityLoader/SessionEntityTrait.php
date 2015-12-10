<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\SessionConverter\EntityLoader;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
trait SessionEntityTrait
{

	/** @var string */
	private $sessionKey;

	/**
	 * @return string
	 */
	public function getSessionKey()
	{
		return $this->sessionKey;
	}

	/**
	 * @param string $key
	 */
	public function setSessionKey($key)
	{
		$this->sessionKey = $key;
	}

	/**
	 * @return string
	 */
	public function getBaseType()
	{
		return 'Arachne\SessionConverter\EntityLoader\SessionEntityInterface';
	}

}
