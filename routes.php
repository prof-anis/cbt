<?php
use App\Utilities\Router\Router;


Router::get('/project/:title/users/index','UserController@index',['auth'],'me');
Router::post( '/project/users/admin', 'UserController@admin');
Router::get('/project/:id/:title/login', 'Views@login_page', [], 'login_page');

?>