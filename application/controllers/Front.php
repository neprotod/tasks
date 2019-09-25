<?php

namespace App\Controllers;

use Sys\View;
use Sys\DB;
use Sys\Core;
use App\Models\Task;


class Front{
    function show($page = 1){

        $data = [];
        $get = [];
        $task = new Task();

        // Проверяем тип запроса
        if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
            $get["errors"] = $task->set($page);
        }

        // Берем данные о странице
        $get += $task->get($page);

        $get["pagination"] = View::render("content.pagination", $get);
        
        $data["content"] = View::render("content.task",$get);


        return View::render("index",$data);
    }


}