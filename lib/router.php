<?php
namespace Lib;

use Aura\Router\Router as AuraRouter;
use Aura\Router\RouteCollection;
use Aura\Router\Generator;
use Aura\Router\RouteFactory;

class Router extends AuraRouter {	
	
	/* !Singleton */
	
	/** @var Lib\Router */
	private static $instance = null;
	
	/**
	 * Get a single instance of the Router class
	 *
	 * @return Router
	 */
	public static function instance()
	{
		if(!self::$instance)
		{
			self::$instance = new Router(
				new RouteCollection(new RouteFactory),
				new Generator
			);
		}
		
		return self::$instance;
	}
	
	
	/* !Construct */
	
	/**
	 * Create a new Router instance
	 *
	 * @param	Aura\Router\RouteCollection 	$routes
	 * @param Aura\Router\Generator		$generator
	 * @return void
	 */
	public function __construct(RouteCollection $routes, Generator $generator)
	{
		parent::__construct($routes, $generator);
		
		// Include the routes, binded to the router
		require_once('../routes.php');
	}
	
	
	/* !Instance */
	
	/**
	 * Process a route for current uri
	 *
	 * @return void
	 */
	public function dispatch()
	{
		$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
				
		$route 	= $this->match($path, $_SERVER);
		
		if($route)
		{
			if(isset($route->values['controller']))
			{
				$controllerClass = 'Controller\\' . $route->values['controller'];
								
				if(class_exists($controllerClass))
				{
					$controllerInstance = new $controllerClass;
					
					if(isset($route->values['action']))
						$actionMethod = $route->values['action'];
					else
						$actionMethod = 'indexAction';
					
					if(is_callable(array($controllerInstance, $actionMethod)))
					{
						$params = $route->params;
						
						unset($params['controller'], $params['action']);
						
						$this->handleResponse(
							call_user_func_array(
								array($controllerInstance, $actionMethod), 
								array_values($params)
							)
						);
					}
				}
			}
		}
		
		$this->handle404();
	}
	
	/**
	 * Prints a 404 error page, if a route can't be found
	 *
	 * @return void
	 */
	private function handle404()
	{
		echo include('../view/404.php');
		exit;
	}
	
	/**
	 * Handle the response given from the executed action
	 *
	 * @param	Lib\Response $response
	 * @return void
	 */	
	private function handleResponse(Response $response)
	{
		$response->dispatch();
	}
		
}