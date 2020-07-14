<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\CliRouter;
use Nette\Application\Routers\Route;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
	    $router = new RouteList;
	    
	    $router[] = new CliRouter(array(
	        'action' => 'Cli:Prize:Minute',
	    ));
	    
	    $router[] = $frontRouter = new RouteList('Front');
	    $frontRouter[] = new Route('/<presenter>/<action>', 'Homepage:default');
	    
	    return $router;
	}
}
