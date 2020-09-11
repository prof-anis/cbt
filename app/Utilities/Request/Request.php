<?php

namespace App\Utilities\Request;

class Request{

	protected $parameters = [];

	function __construct(){
		$this->merge()
			->sanitize();
	}

	function __get($property){
		return $this->parameters[$property];
	}

	function __set($property,$value){
		$this-> parameters[$property] = $value;
	}

	protected function merge(){
		$this->parameters = array_merge($_POST,$_GET);
		return $this;
	}
	protected function sanitize(){
		foreach ($this->parameters as $key => $value) {
			$this->parameters[$key] = trim(strip_tags($value));
		}
	}

	public function get($value = ''){
		if ($value == '') {
			return $this->parameters;
		}
		return $this->parameters[$value];
	}

	public function server($value =''){
		if ($value == '') {
			return $_SERVER;
		}

		return $_SERVER[$value];
	}

	 

}