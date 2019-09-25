<?php

namespace App\Models;

use Sys\View;
use Sys\DB;
use Sys\Core;
use Sys\Response;
use Sys\Router;

class User{
    /**
     * Получить пользователя
     *
     * @return bool
     */
     function checkUser(){
        $errors = [];



        $login = Response::isset($_POST["login"]);
        $pass = Response::isset($_POST["pass"]);

        if(empty($login)){
            $errors["login"] = "Empty login";
        }
        if(empty($pass)){
            $errors["pass"] = "Empty password";
        }

        if(!empty($errors)){
            return $errors;
        }

        $sql = "SELECT login FROM user WHERE login = :login and pass = :pass";
        
        if($test = DB::select($sql,[":login" => $login, ":pass" => md5($pass)])){
            // Заполняем сессию и переносим на страницу админа
            $_SESSION["guard"] = $test;
            Router::redirect("/admin/tasks",301,"Login successful");
            return [];
        }

        $errors["valid"] = "No such user";

        return $errors;

     }

}