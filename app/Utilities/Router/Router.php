<?php

namespace App\Utilities\Router;
use App\Utilities\Router\ProcessUri;

 

class Router{

	protected static $routes;
	public $route_params = [];

	protected $routePath = __DIR__."/../../../routes.php";

	function __construct(){
		$this->loadRoutes();
		$this->retrieveUri();
		// $this->processRoute('project/name');
		
		return $this->runChecks();
	}

	protected function retrieveUri() : string
	{
		return $_SERVER['REQUEST_URI'];
	}

	public static function match($request_method,$uri,$controller){
		self::$routes[] = [ 'method'=>$request_method,'uri'=>$uri ,'controller'=> $controller ];
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
			if ($this->processRoute($route['uri'])) {

				$not_found = false;
				$controller = $route['controller'];
				$controller = explode('@', $controller);
				$class = "App\Controllers\\$controller[0]";
				
				$class = new $class;
				$method = $controller[1];

				return $class->$method(...$this->route_params);

			}
			else{
				$this->route_params = [];
				$not_found = true;
			}
		}

		if ($not_found) {
			echo "404 not found";
			exit;
		}
	}

	protected function processRoute($route){
		// dd($this->serverRoutetoArray());
		// var_dump($this->serverRoutetoArray());
		// echo "<br>";
		// var_dump(explode('/', $route));
		// echo "<br>";
		// dd($route);
		$server_route_array = $this->serverRoutetoArray();
		$route_array = explode('/', $route);
		$route_array = $this->trimRouteArray($route_array);
		if (count($route_array)!=count($server_route_array)) {
			return false;
		}
		$comparison_response = [];
		for ($i=0; $i < count($route_array); $i++) { 
			if (strpos($route_array[$i], ':') > -1) {
				$this->route_params[] = $server_route_array[$i];
				
				$comparison_response[] = true;
			}else {
				$comparison_response[] = ($server_route_array[$i] == $route_array[$i])? true: false;
			}
		}

		return !in_array(false,$comparison_response);
	}
	protected function serverRoutetoArray(){
		$server_route_array =  explode('/', $this->retrieveUri());
		$trimmed_array = [];
		foreach ($server_route_array as $key => $value) {
			if ($value != "") {
				$trimmed_array[] =$value;
			}	
		}
		return $trimmed_array;
	}
	protected function trimRouteArray($route_array){
		$trimmed_array = [];
		foreach ($route_array as $key => $value) {
			if ($value != "") {
				$trimmed_array[] =$value;
			}	
		}
		return $trimmed_array;
	}
}

?>