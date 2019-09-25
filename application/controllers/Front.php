<?php

namespace App\Controllers;

use Sys\View;

class Front{
    function show(){
        return View::render("index");
    }
}