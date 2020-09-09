<?php
/**
 * 
 */

namespace App\Utilities\View;

class View 
{
	protected $viewPath = __DIR__."/../../../resources/views";

	function __construct()
	{
		
	}

	public function show($view,array $options){
		extract($options);

		if (file_exists($this->viewPath."/".$view.".php")) {
			require($this->viewPath."/".$view.".php");
		}
		else{
			throw new \Exception("$view not found", 1);
			
		}

	}
}