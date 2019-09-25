<div class="sort">
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sort
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="#">By name</a>
            <a class="dropdown-item" href="#">By e-mail</a>
            <a class="dropdown-item" href="#">By state</a>
        </div>
    </div>
</div>

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
                    <div class="error text-danger"><?=\Sys\Response::isset($errors["name"])?></div>
                </div>
                <div class="user_email">
                    <span class="info">E-mail:</span>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" value="<?=\Sys\Response::post("email")?>">
                    <div class="error text-danger"><?=\Sys\Response::isset($errors["email"])?></div>
                </div>
            </div>
            <div class="col">
                <span class="info">Task:</span>
                <textarea class="form-control" name="task" rows="3"><?=\Sys\Response::post("task")?></textarea>
                <div class="error text-danger"><?=\Sys\Response::isset($errors["task"])?></div>
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
                
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>

<?=$pagination?>