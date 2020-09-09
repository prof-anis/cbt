<?php

require "vendor/autoload.php";

use App\Utilities\Router\Router;


function dd($var){
    var_dump($var);
    exit;
}
$router = new Router;