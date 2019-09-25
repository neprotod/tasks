<div class="sort">
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sort
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="<?=\Sys\Router::setQuery(['sort'=>'name'],"/front/show/1")?>">By name</a>
            <a class="dropdown-item" href="<?=\Sys\Router::setQuery(['sort'=>'email'],"/front/show/1")?>">By e-mail</a>
            <a class="dropdown-item" href="<?=\Sys\Router::setQuery(['sort'=>'compleate'],"/front/show/1")?>">By state</a>
        </div>
    </div>
    <?php if(!\Sys\Router::getQuery("desc")):?>
        <a class="btn btn-success" href="<?=\Sys\Router::setQuery(['sort'=>\Sys\Router::getQuery("sort"),"desc" => "true"],"/front/show/1")?>">Descending</a>
    <?php else:?>
        <a class="btn btn-success" href="<?=\Sys\Router::setQuery(['sort'=>\Sys\Router::getQuery("sort")],"/front/show/1")?>">Ascending</a>
    <?php endif;?>
    
</div>
<?php if(isset($message)):?>
<div class="alert alert-success message" role="alert">
    <?=$message?>
</div>
<?php endif;?>
<form class="card task create" method="post" action="<?=Sys\Router::getURI()?>">
    <div class="card-header">
        <div class="row">
            <div class="col-3">
                Create task
            </div>
        </div>
    </div>
    <div class="card-body form-group">
        <div class="row">
            <div class="col-3">
                <div class="user_name">
                    <span class="info">Name:</span>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="<?=\Sys\Response::post("name")?>">
                    <div class="error text-danger"><?=isset($errors["name"])?$errors["name"]:''?></div>
                </div>
                <div class="user_email">
                    <span class="info">E-mail:</span>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" value="<?=\Sys\Response::post("email")?>">
                    <div class="error text-danger"><?=isset($errors["email"])?$errors["email"]:''?></div>
                </div>
            </div>
            <div class="col">
                <span class="info">Task:</span>
                <textarea class="form-control" name="task" rows="3"><?=\Sys\Response::post("task")?></textarea>
                <div class="error text-danger"><?=isset($errors["task"])?$errors["task"]:''?></div>
                <button id="task_submit" type="submit" class="btn btn-success">Send</button>
            </div>
        </div>
    </div>
</form>

<?php foreach($tasks as $task):?>
<div class="card task">
    <div class="card-header">
        <div class="row">
            <div class="col-3">
                <?=$task['create']?>
            </div>
            <div class="col">
                <?php if($task["edit"]):?>
                    Edited by admin
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <div class="user_name">
                    <span class="info">Name:</span>
                    <span class="string"><?=$task['name']?></span>
                </div>
                <div class="user_email">
                    <span class="info">E-mail:</span>
                    <span class="info"><?=$task['email']?></span>
                </div>
            </div>
            <div class="col">
                <?=$task['task']?>
            </div>
            <div class="col-1">
                <?php if($task["compleate"]):?>
                    <div class="check"></div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>

<?=$pagination?>