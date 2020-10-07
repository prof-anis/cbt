<?php
namespace App\MiddleWares;
class isStaff{
    function handle(){
        if ($_SESSION['role'] != "student") {
            return true;
        }
        return false;
    }

    public function failed(){
        echo " You are not authorized to view this page, Not a teacher. Redirecting...";
        sleep(1);
        header("Location: http://localhost/project/index");
    }

}