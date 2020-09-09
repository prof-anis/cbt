<?php

require "vendor/autoload.php";

require __DIR__."/app/Utilities/Helper/Helper.php";

use App\Utilities\Router\Router;


function dd($var){
    var_dump($var);
    exit;
}
$router = new Router;