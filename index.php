<?php

require "vendor/autoload.php";

use App\QueryBuilder;

$qb = new QueryBuilder;

var_dump($qb->select("first_name")->from("users")->where([['id','4','<']])->get());