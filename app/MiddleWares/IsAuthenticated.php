<?php

namespace App\MiddleWares;
class IsAuthenticated {
    
    public function handle(){
        return false;
    }
    public function failed(){
        echo " You are not authorized to view this page, Please Login First";
        redirect('');
    }
}