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
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class SessionConverterExtension extends CompilerExtension
{

	/** @var array */
	public $defaults = [
		'entities' => [
			'Arachne\SessionConverter\EntityLoader\SessionEntityInterface',
			'Arachne\SessionConverter\EntityLoader\SessionEntity',
		],
	];

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		$builder->addDefinition($this->prefix('sessionConverter'))
			->setClass('Arachne\SessionConverter\EntityLoader\SessionConverter')
			->addTag(EntityLoaderExtension::TAG_FILTER_IN, $config['entities'])
			->addTag(EntityLoaderExtension::TAG_FILTER_OUT, $config['entities']);
	}

}
