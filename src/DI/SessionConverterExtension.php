<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\SessionConverter\DI;

use Arachne\EntityLoader\DI\EntityLoaderExtension;
use Nette\DI\CompilerExtension;

/**
 * @author Jáchym Toušek
 */
class SessionConverterExtension extends CompilerExtension
{

	/** @var array */
	public $defaults = [
		'entities' => [],
	];

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		$builder->addDefinition($this->prefix('sessionConverter'))
			->setClass('Arachne\SessionConverter\EntityLoader\SessionConverter')
			->addTag(EntityLoaderExtension::TAG_CONVERTER, $config['entities']);
	}

}
