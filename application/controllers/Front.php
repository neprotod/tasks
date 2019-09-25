<?php

namespace App\Controllers;

use Sys\View;
use Sys\DB;
use Sys\Core;
use Sys\Response;
use App\Models\Task;


class Front{
    function show($page = 1){
        $data = [
            "title" => "Task list",
        ];
        $get = [];
        $task = new Task();

        // Проверяем тип запроса
        if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
            $get["errors"] = $task->set($page);
        }

        // Берем данные о странице
        $get += $task->get($page);
        $get["url"] = '/front/show/';
        $get["pagination"] = View::render("content.pagination", $get);
        
        //Проверяем есть ли сообщения удачного завершения
        $get["message"] = Response::message();

        $data["content"] = View::render("content.task",$get);


        return View::render("index",$data);
    }


}