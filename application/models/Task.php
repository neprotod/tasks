<?php

namespace App\Models;

use Sys\View;
use Sys\DB;
use Sys\Core;
use Sys\Response;
use Sys\Router;
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
        $count = DB::select("SELECT count(*) FROM tasks")[0];

        $data["pagination"] = $this->pagination($page + 1,$count, $pagination);

        $sql_params = [];
        $sql = "SELECT id, name, email, task, `create`, edit, compleate 
                FROM tasks"; 
        
        
        // Делаем сортировку
        if($sort = Router::getQuery("sort")){
            $sort = Response::to_type($sort,"string");
            $sql .= " ORDER BY $sort";
            
            if(Router::getQuery("desc")){
                $sql .= " DESC";
            }
            
        }
        
        // Добавляем лимит
        $sql .= " LIMIT :step, :pagination";

        $sql_params[":pagination"] = $pagination;
        $sql_params[":step"] = $step;
        
        // Берем данные из базы
        $data["tasks"] = DB::like($sql,$sql_params);
        
        
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
        
        
        // Делаем редирект
        Router::redirect(null,301,"Task added");
    }
    /**
     * Редактирование задачи
     * 
     * @return void
     */
    function edit(){
        $post = $_POST;

        $update = [];
        $data = [];
        $data['id'] = htmlentities($post["id"]);
        $data['name'] = htmlentities($post["name"]);
        $data['email'] = htmlentities($post["email"]);
        $data['task'] = htmlentities($post["task"]);
        $compleate = isset($post["compleate"])?$post["compleate"]:0;

        $task = DB::selects("SELECT id, name, email, task, compleate FROM tasks WHERE id = :id",[':id' => $data['id']]);

        $task = $task[0];
        if($compleate != $task['compleate']){
            $update["compleate"] = $compleate;
            unset($task['compleate']);
        }

        $edit = false;
        
        
        foreach($data as $key => $value){
            if($task[$key] != $value){
                $edit = true;
                $update[$key] = $value;
            }
        }
        if(empty($update)){
            return false;
        }
        if($edit){
            $update["edit"] = 1;
        }

        $field = '';
        $params = [];
        foreach($update as $key => $value){
                $edit = true;
                $field .= $key."=".':'.$key.',';
                $params[':'.$key] = $value;
        }

        $field = trim($field,',');
        
        $params["id"] = $task['id'];

        // Сохраняем результат
        DB::query("UPDATE tasks
                          SET $field
                          WHERE id = :id",$params);
        
        
        
        // Делаем редирект
        Router::redirect(null,301,"Task update");
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