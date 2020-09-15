<?php
use App\Utilities\Router\Router;
use App\Utilities\View\View;

// Router::get('/project/:title/users/index','UserController@index',['auth'],'me');
Router::get('/project/index', 'Views@indexPage', [], 'home');
Router::post('/project/login', 'Views@loginPage', [], 'login');


?>