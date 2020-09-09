<?php
namespace App\Utilities\Router;
class ProcessUri{
    public function processUriVariable($uri){
        $uri_array = explode('/', $uri);
       if (count($uri_array) < 4) {
          return $uri;
       }else {
           # code...
       }

    }
}