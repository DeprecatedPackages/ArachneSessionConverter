<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\SessionConverter;

/**
 * @author Jáchym Toušek
 */
interface ISessionEntity
{

	/**
	 * @return string
	 */
	public function getSessionKey();

	/**
	 * @param string $key
	 */
	public function setSessionKey($key);

}
