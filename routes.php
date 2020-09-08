<?php
use App\Utilities\Router\Router;


Router::match('GET','/framework/users/index','UserController@index');

?>