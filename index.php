<?php

require "vendor/autoload.php";

require __DIR__."/app/Utilities/Helper/Helper.php";

use App\Utilities\Router\Router;
use App\Model\User;
use App\Utilities\Request\Request;
session_start();

$router = new Router;
$router->run();
