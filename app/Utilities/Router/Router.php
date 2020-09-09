<?php

namespace App\Utilities\Router;
use App\Utilities\Router\ProcessUri;

 

class Router{

	protected static $routes;

	protected $routePath = __DIR__."/../../../routes.php";

	function __construct(){
		$this->loadRoutes();
		$this->retrieveUri();
		
		return $this->runChecks();
	}

	protected function retrieveUri() : string
	{
		return $_SERVER['REQUEST_URI'];
	}

	public static function match($request_method,$uri,$controller){
		$process_url = new ProcessUri();
		$processed_uri = $process_url->processUriVariable($uri);
		self::$routes[] = [ 'method'=>$request_method,'uri'=>$processed_uri ,'controller'=> $controller ];
	}

	protected function loadRoutes(){

		if (file_exists($this->routePath)) {
			require $this->routePath;
		}
		else{
			throw new \Exception("routes not found", 1);
			
		}
	}

	protected function runChecks(){
		$not_found = true;

		foreach (self::$routes as $key => $route) {

			if ($route['uri'] == $this->retrieveUri()) {

				$not_found = false;
				$controller = $route['controller'];
				$controller = explode('@', $controller);
				$class = "App\Controllers\\$controller[0]";
				
				$class = new $class;
				$method = $controller[1];

				return $class->$method();

			}
			else{
				$not_found = true;
			}
		}

		if ($not_found) {
			return "404 not found";
		}
	}




}

?>