<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\SessionConverter\EntityLoader;

use ArrayObject;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class SessionEntity extends ArrayObject implements SessionEntityInterface
{

	use SessionEntityTrait;

	public function __construct($input = [])
	{
		parent::__construct($input);
		$this->setFlags(ArrayObject::ARRAY_AS_PROPS);
	}

}
