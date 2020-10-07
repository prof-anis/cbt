<?php

return [
    'auth' =>  \App\MiddleWares\IsAuthenticated::class,
    'staff' => \App\MiddleWares\isStaff::class,
    'student' => \App\MiddleWares\isStudent::class,    
];