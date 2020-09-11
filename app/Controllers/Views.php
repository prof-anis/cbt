<?php

namespace App\Controllers;

class Views{
		public function login_page(){
		$user = "Sam's Tab";
		$email = "sammy@gmail.com";
		$role = "Owner";

		return render("index",['user'=>$user, 'email'=>$email, 'role'=>$role]);
		
	}
	
	public function admin(){
		echo "U are in the admin page";
	}
}