<?php
namespace App\Controllers;

use App\Utilities\DB\QueryBuilder;

class Views{
	public $courses;
    
    public function indexPage(){
		$courses = new Courses;
		$courses = $courses->getCourses();
		session_start();
		$email = $_SESSION['name'];
		return render('admin', ['email'=>$email, 'courses'=>$courses]);
	}

	public function index(){
		return render('index', []);
	}

}

?>