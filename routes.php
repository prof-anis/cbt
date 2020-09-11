<?php
use App\Utilities\Router\Router;


Router::get('/framework/users/index','UserController@index',['auth'],'me');
Router::post( '/framework/users/admin', 'UserController@admin');
Router::get('/framework/:id/:title/login', 'Views@login_page', [], 'login_page');

?>