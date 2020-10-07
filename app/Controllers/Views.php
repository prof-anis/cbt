<?php
namespace App\Controllers;

use App\Utilities\DB\QueryBuilder;

class Views{
	public $courses;
    
    public function indexPage(){
		$courses = new Courses;
		$courses = $courses->getCourses();
		
		$email = $_SESSION['name'];
		if ($_SESSION['role'] == 'student'){
			header('Location: /project/student/index');
		}
		return render('admin', ['email'=>$email, 'courses'=>$courses]);
	}

	public function studentIndexPage(){
		
		if (!isset($_SESSION['logged_in'])) {
			header('Location: /project/account/login');
		}
		if ($_SESSION['role'] != 'student'){
			header('Location: /project/index');
		}
		return render('Students/index', ['email' => $_SESSION['name']]);
	}

}