<?php

use App\Utilities\View\View;
use App\Utilities\Config\Config;
use App\Utilities\Request\Request;
use App\Utilities\Router\Router;

function render($view,$option = []){
	$viewInstance = new View();
	return $viewInstance->show($view,$option);
}

function config($value){
	return Config::getConfig($value);
}

function request(){
	$request = new Request;
	return $request;
}

function route($name,$param = []){
	$router = new Router();
	return $router->route($name,$param);
}

function asset($url){
	return View::asset($url);
}