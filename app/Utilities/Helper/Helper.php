<?php

use App\Utilities\View\View;
use App\Utilities\Config\Config;

function render($view,$option){
	$viewInstance = new View();
	return $viewInstance->show($view,$option);
}

function config($value){
	return Config::getConfig($value);
}