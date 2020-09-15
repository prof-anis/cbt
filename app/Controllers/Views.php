<?php

namespace App\Controllers;

class Views{


	public function indexPage(){
		return render('index', []);
	}

	public function loginPage(){
		return render('login', []);
	}


}