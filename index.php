<?php

require "vendor/autoload.php";

require __DIR__."/app/Utilities/Helper/Helper.php";

use App\Utilities\Router\Router;
// use App\Utilities\DB\QueryBuilder;

$router = new Router;

// $qb = new QueryBuilder;
// var_dump($qb->select()->from("posts")->get());