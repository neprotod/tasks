<?php

namespace App\Models;

use Sys\View;
use Sys\DB;
use Sys\Core;
class Task{
    /**
     * Берем страницу с задачами
     * 
     * @param int номер страницы
     * @return array
     */
    function get($page = 1){

        // Уменьшаем для правильного просчета
        if((--$page) < 0){
            $page = 0;
        }

        $data = [];

        $pagination = Core::config("page.pagination");

        

        $step = $pagination * $page;

        // Для пагинации
        $count = DB::select("SELECT count(*) FROM tasks");


        $data["pagination"] = $this->pagination($page + 1,$count, $pagination);

        // Берем данные из базы
        $data["tasks"] = DB::like("SELECT id, name, email, task, `create`, edit, compleate 
                                FROM tasks 
                                LIMIT :step, :pagination",[":pagination" => $pagination,":step"=>$step],true);
        
        
        return $data;
    }
    /**
     * Добавляем задачу
     * 
     * @return array с ошибками если они есть
     */
    function set(){
        $errors = [];

        $post = $_POST;

        $name = htmlentities($post["name"]);
        $email = htmlentities($post["email"]);
        $task = htmlentities($post["task"]);

        if(empty($name)){
            $errors["name"] = "Empty name";
        }
        if(empty($email)){
            $errors["email"] = "Empty e-mail";
        }
        elseif(!stristr($email,"@")){
            $errors["email"] = "No valid e-mail";
        }
        if(empty($task)){
            $errors["task"] = "Empty task";
        }

        // Если проверки не прошли успешно
        if(!empty($errors))
            return $errors;

        // Сохраняем результат
        $var = DB::query("INSERT INTO tasks(name,email,task)
                     VALUES(:name,:email,:task)",[
                                                    ":name" =>$name,
                                                    ":email" =>$email,
                                                    ":task" =>$task,
                                                    ]);
        
        return [];
    }

    /**
     * Высчитывает пагинацию
     * 
     * @param int текущая страница
     * @param int всего элементов
     * @param int шаги пагинации
     * @return array
     */
    public function pagination($page, $count, $pagination){
        $to_pagination = [];

        $to_pagination["current"] = $page;
        // Считаем количество страниц
        $to_pagination["pages"] = ceil($count / $pagination);

        $start = $to_pagination["current"] - 1;
        $end = $to_pagination["current"] + 1;
        


        // Берем начало и конец пагинации
        $to_pagination["start"] = ($start < 1)? 1: $start;
        $to_pagination["end"] = ($end > $to_pagination["pages"])? $to_pagination["pages"]: $end;

        // Делаем смещение если мы на конце пагинации
        if($to_pagination["start"] == $to_pagination["current"]){
            if(($to_pagination["end"] + 1) <= $to_pagination["pages"])
                $to_pagination["end"]++;
        }
        if($to_pagination["end"] == $to_pagination["current"]){
            if(($to_pagination["start"] - 1) >= 1)
            $to_pagination["start"]--;
        }

        return $to_pagination;
    }
}