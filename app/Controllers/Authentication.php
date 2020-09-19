<?php

namespace App\Controllers;

use App\Utilities\DB\QueryBuilder;

class Authentication{

	public $courses;

	public function loginPage(){
		$this->checklogin();
		return render('Userauthentication/login', []);
	}

	public function checklogin(){
		session_start();
		if (isset($_SESSION['logged_in'])) {
			header('Location: /project/index');
		}else {
			$this->login();
		}
	}
	
	public function login(){
		$email = isset($_POST['email'])? $_POST['email'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$qb = new QueryBuilder();
		$user = $qb->select('id','email', 'password')->from('accounts')->where([['email', $email]])->get();
		if($user){
			if (password_verify($password, $user['password'])) {
				// Verification success! User has loggedin!
				// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
				session_regenerate_id();
				$_SESSION['logged_in'] = TRUE;
				$_SESSION['name'] = $user['email'];
				$_SESSION['user_id'] =$user['id'];
				// $_SESSION['id'] = $id;
				header('Location: /project/index');
			} else {
				// Incorrect password
				$_SESSION['error'] = 'Incorrect Email and/or password!';
				// unset($_SESSION['error']);
			}
		} else {
				if (!empty($_POST['email']) && !empty($_POST['password'])) {
					$_SESSION['error'] = 'Incorrect Email and/or password!';
					// unset($_SESSION['error']);
				}
				
			
		}
		
		
	}

	public function logoutPage(){
		session_start();
		session_destroy();
		// Redirect to the login page:
		header('Location: /project/index');
	}

	public function profilePage(){
		$user = $this->getProfile();
		$courses = new Courses;
		$courses = $courses->getCourses();
		$user_id = $user['id'];
		$user_name = $user['username'];
		$password = "For security reasons, raw passwords are not stored<br> To reset your password, fill this form";
		$email = $user['email'];
		return render('Userauthentication/profile', ['user_id'=>$user_id, 'password'=>$password, 'email'=>$email, 'username'=>$user_name, 'courses' => $courses]);
	}
	public function getProfile(){
		
		// We need to use sessions, so you should always start sessions using the below code.
		session_start();
		// If the user is not logged in redirect to the login page...
		if (!isset($_SESSION['logged_in'])) {
			header('Location: /project/index');
			// exit;
		}
		$qb = new QueryBuilder;
		$user = $qb->select()->from('accounts')->where([['id', $_SESSION['user_id']]])->get();
		return $user;
	}

	public function editProfilePage(){
		$courses = new Courses;
		$courses = $courses->getCourses();
		$user = $this->getProfile();
		// exit(var_dump($user));
		if (isset($_POST['edit_profile_submit']) && isset($_POST['edit_username']) && isset($_POST['edit_email'])){
			
			if (!empty($_POST['edit_username']) || !empty($_POST['edit_email'])) {
				$this->editProfile($_SESSION['user_id']);
				header('Location: /project/account/profile');
			}

		}
		$user_id = $_SESSION['user_id'];
		$email = $user['email'];
		$username = $user['username'];

		return render('Userauthentication/edit_profile', ['user_id'=>$user_id, 'email'=>$email, 'username'=>$username, 'courses'=>$courses]);
	}

	public function editProfile($user_id){
		$qb = new QueryBuilder;
		$query = $qb->update('accounts', ["username" => $_POST['edit_username'], "email"=>$_POST['edit_email']])->where([['id', $user_id]])->get();
		return $query;
	}

	public function registerPage(){
		$this->checkForm();
		return render('Userauthentication/register');
	}

	public function checkForm(){
		if(isset($_POST['submit_register'])){

			if (!isset($_POST['username_register'], $_POST['password_register'], $_POST['confirm_password_register'],$_POST['email_register'], $_POST['first_name'], $_POST['last_name'])) {	
				$_SESSION['error'] = 'Please complete the registration form! 1';
				// Make sure the submitted registration values are not empty.
			}

			elseif (empty($_POST['username_register']) || empty($_POST['password_register']) || empty($_POST['confirm_password_register']) || empty($_POST['email_register']) || empty($_POST['first_name']) || empty($_POST['last_name'])) {
				$_SESSION['error'] = 'Please complete the registration form! 2';
			}

			elseif ($_POST['password_register'] != $_POST['confirm_password_register']) {
				//Passwords do not match
				$_SESSION['error'] = 'Passwords do not match';
			}
			else{
					// Form Accurate and Password match
					$this->checkUser();
			}
		
			
		}
	}

	public function checkUser(){
		//Check if account already exists in database
		$qb = new QueryBuilder;
		$possible_account = $qb->select('id', 'password')->from('accounts')->where([['username', $_POST['username_register']]])->get();
		if($possible_account != NULL){
			$_SESSION['error'] = " User with that username already exists<br>";
		}else {
			$this->register();
		}
	}

	public function register(){
		session_start();
		$password = password_hash($_POST['password_register'], PASSWORD_DEFAULT);
		$qb = new QueryBuilder;
		$new_user = $qb->insert('accounts', ['username'=>$_POST['username_register'], 'first_name'=>$_POST['first_name'], 'last_name'=>$_POST['last_name'], 'email'=>$_POST['email_register'], 'password'=>$password])->get();
		// session_destroy();
		header('Location: /project/index');
	}

	
}