<?php

namespace App\Controllers;

use Sys\View;
use Sys\DB;
use Sys\Core;
use Sys\Response;
use Sys\Router;
use App\Models\Task;
use App\Models\User;


class Admin{
    /**
     * Вход в систему
     */
    public function login(){
        $data = [
            "title" => "Login",
        ];

        // Проверяем тип запроса
        if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
            $user = new User();
  
            $data["errors"] = $user->checkUser();
        }


        $data['content'] = View::render("admin.login", $data);

        return View::render("index",$data);
    }
    /**
     * Выход из системы
     */
    public function logout(){
        unset($_SESSION["guard"]);
        Router::redirect("/",301);
    }

    
    /**
     * Управление задачами
    */
    public function tasks($page = 1){
        if(!isset($_SESSION['guard'])){
            Router::redirect("/admin/login",301);
        }
        $data = [
            "title" => "Administration",
        ];
        $get = [];
        $task = new Task();

        // Проверяем тип запроса
        if(strtolower($_SERVER['REQUEST_METHOD']) == "post"){
            $task->edit();
            //$get["errors"] = $task->set($page);

        }


        // Берем данные о странице
        $get += $task->get($page);
        $get["url"] = '/admin/tasks/';

        $get["pagination"] = View::render("content.pagination", $get);

        //Проверяем есть ли сообщения удачного завершения
        $get["message"] = Response::message();

        $data["content"] = View::render("admin.task",$get);

        return View::render("index",$data);
    }
}