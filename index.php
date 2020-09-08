<?php

require "vendor/autoload.php";

use App\QueryBuilder;

$qb = new QueryBuilder;

$qb->delete()->from("posts")->where([['id', '19', '>']])->get();

// $qb->insert("posts", ["title"=>"Query Builder Post", "body"=>"Query Builder Hacked", "author"=>"Query Builder Class"])->get();