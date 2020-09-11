<?php

require "vendor/autoload.php";

require __DIR__."/app/Utilities/Helper/Helper.php";

use App\Utilities\Router\Router;
use App\Model\User;
use App\Utilities\Request\Request;



// use App\Utilities\DB\QueryBuilder;
$router = new Router;
$router->run();
// var_dump(route('login_page', ['1','how to be a boy']));
// $qb = new QueryBuilder;
// var_dump($qb->select()->from("posts")->get());