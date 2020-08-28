<?php

require "vendor/autoload.php";

use App\QueryBuilder;

$qb = new QueryBuilder;

echo($qb->insert("posts", ["title"=>"Query Builder Post", "body"=>"Query Builder Body", "author"=>"Query Builder Class"])->get());