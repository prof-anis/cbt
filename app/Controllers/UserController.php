<?php

namespace App\Controllers;

class UserController{
	public function index(){
		$user = "tobi";

		return render("index",['user'=>$user]);
		
	}
	
	public function admin(){
		echo "U are in the admin page";
	}
}