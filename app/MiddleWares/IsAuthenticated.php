<?php

namespace App\MiddleWares;
class IsAuthenticated {
    
    public function handle(){
        if (isset($_SESSION['logged_in'])) {
            return true;
        }
        return false;
    }
    public function failed(){
        echo " You are not authorized to view this page, Please Login First";
        header("Location: ".route('login')."");
    }
}