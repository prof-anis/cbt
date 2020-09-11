<?php
use App\Utilities\Router\Router;


Router::get('/project/users/index','UserController@index',['auth']);
Router::post( '/project/users/admin', 'UserController@admin');
Router::get('/project/:id/:title/login', 'Views@login_page');

?>