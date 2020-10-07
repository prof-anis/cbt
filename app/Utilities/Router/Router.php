<?php

namespace App\Utilities\Router;
use App\Utilities\Router\ProcessUri;

 

class Router{

	protected static $routes;
	public $route_params = [];

	protected $routePath = __DIR__."/../../../routes.php";

	function __construct(){
		
	}

	protected function retrieveUri() : string
	{
		$uri = explode("?", $_SERVER['REQUEST_URI']);
		return $uri[0];
	}

	public static function get($uri,$controller, $middleware = [],$name = ''){
		self::match('GET',$uri,$controller, $middleware,$name);
	}

	public static function post($uri,$controller, $middleware = [], $name = ''){
		self::match('POST',$uri,$controller, $middleware, $name);
	}

	public static function match($request_method,$uri,$controller, $middleware = [],$name = ''){
		self::$routes[] = [ 'method'=>$request_method,'uri'=>$uri ,'controller'=> $controller, 'middleware' => $middleware,'name'=>$name];
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
				$middleware_status = $this->checkMiddleware($route);
				// exit("$middleware_status");
				if ($middleware_status) {
					$class = new $class;
					$method = $controller[1];
					return $class->$method(...$this->route_params);
				}
				exit;
			}
			else{
				$this->route_params = [];
				$not_found = true;
			}
		}

		if ($not_found) {
			return render('404_page');
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
	protected function checkMiddleware($route){
		$middleware = $route['middleware'];
		// exit(var_dump($middleware));
		foreach ($middleware as $key => $value) {
			 $ware_class_name = config("middleware.$value");
			 $ware_class = new $ware_class_name;
			 if($ware_class->handle()){
			 }else {
				 if(method_exists($ware_class,'failed')){
					$ware_class->failed();
					return true;
				 }
				 return false;
			 }

		}
		
		return true;
	}

	public function route($name,array $param = []){
		$route_uri_array = [];
		$host = request()->server('HTTP_HOST');
		foreach (self::$routes as $key => $route) {
			if ($route['name'] == $name) {
				$route_uri = $route['uri'];
				$route_uri_array = explode('/', $route_uri);
				$route_uri_array = $this->trimRouteArray($route_uri_array);

				for ($i=0; $i < count($route_uri_array); $i++) { 
					if(strpos($route_uri_array[$i], ':') > -1){
						//this is a route parameter
						$strip = str_replace(":","",$route_uri_array[$i]);
						$route_uri_array[$i] = $param[$strip];
					}
				}
			}
				
		}
		$processed_uri = implode("/", $route_uri_array);
		return "http://".$host."/".$processed_uri;
	}


	public function run(){
		$this->loadRoutes();
		$this->retrieveUri();
		// $this->processRoute('project/name');
		
		return $this->runChecks();
	}
}

?>