<?php

use App\Utilities\Router\Router;

// Router::get('/project/:title/users/index','Authentication@index',[],'me');
Router::get('/project/index', 'Views@indexPage', ['auth'], 'home');
Router::post('/project/account/login', 'Authentication@loginPage', [], 'login');
Router::get('/project/account/logout', 'Authentication@logoutPage', [], 'logout');
Router::get('/project/account/profile','Authentication@profilePage', [], 'profile');
Router::get('/project/account/profile/:id/edit', 'Authentication@editProfilePage', [], 'profile_edit');
Router::get('/project/account/register', 'Authentication@registerPage', [], 'register');
Router::get('/project/courses/add', 'Courses@addCoursePage', [], 'add_course');
// Router::post('/project/account/profile/:id/')


?>