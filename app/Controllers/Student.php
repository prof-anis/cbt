<?php
namespace App\Controllers;

class Student{
    public function studentProfilePage(){
        $profile = new Authentication;
		$user = $profile->getProfile();
		$courses = new Courses;
		$courses = $courses->getCourses();
		$user_id = $user['id'];
		$user_name = $user['username'];
		$password = "For security reasons, raw passwords are not stored<br> To reset your password, fill <a href = password_reset>this form</a>";
		$email = $user['email'];
		return render('Students/student_profile', ['user_id'=>$user_id, 'password'=>$password, 'email'=>$email, 'username'=>$user_name]);
    }
    
    public function editStudentProfilePage(){
		$courses = new Courses;
        $courses = $courses->getCourses();
        $new_user = new Authentication;
		$user = $new_user->getProfile();
		if (isset($_POST['edit_profile_submit']) && isset($_POST['edit_username']) && isset($_POST['edit_email'])){
			
			if (!empty($_POST['edit_username']) || !empty($_POST['edit_email'])) {
				$new_user->editProfile($_SESSION['user_id']);
				header('Location: /project/student/account/profile');
			}

		}
		$user_id = $_SESSION['user_id'];
		$email = $user['email'];
		$username = $user['username'];

		return render('Students/edit_student_profile', ['user_id'=>$user_id, 'email'=>$email, 'username'=>$username, 'courses'=>$courses]);
	}
}