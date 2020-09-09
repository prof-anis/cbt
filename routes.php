<?php
use App\Utilities\Router\Router;


Router::match('GET','/framework/users/index','UserController@index');
Router::match('GET', '/framework/users/admin', 'UserController@admin');
Router::match('GET', '/framework/:id/:title/login', 'Views@login_page');

?>