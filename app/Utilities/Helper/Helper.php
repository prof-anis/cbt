<?php

use App\Utilities\View\View;

function render($view,$option){
	$viewInstance = new View();
	return $viewInstance->show($view,$option);
}