<?php

declare(strict_types=1);

namespace App;

use Nette\Configurator;
use Tracy\Debugger;
class Bootstrap
{
	public static function boot(): Configurator
	{
	    
		$configurator = new Configurator;
		$configurator->enableTracy(__DIR__ . '/../log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig(__DIR__ . '/config/common.neon');
		
		$configurator->setDebugMode(true);
	    Debugger::enable(Debugger::DEVELOPMENT);
		Debugger::$strictMode = false;

		return $configurator;
	}
}
