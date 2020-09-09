<?php

namespace App\Controllers;

class Views{
    public function login_page($arti_id, $titl){
        echo "You are now in the login page";
        echo $arti_id."<br>".$titl;
    }
}