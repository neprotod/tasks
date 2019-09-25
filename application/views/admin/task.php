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

<?php foreach($tasks as $task):?>
<form class="card task admin create" method="post" action="<?=Sys\Router::getURI()?>">
    <input type="hidden" name="id"  value="<?=$task["id"]?>">
    <div class="card-header">
        <div class="row">
            <div class="col-5">
                <?=$task['create']?>
            </div>
            <div class="col-3">
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <?php
                            if($task['compleate']):
                        ?>
                            <input name="compleate" type="checkbox" class="form-check-input" checked='checked' value="1">
                        <?php
                            else:
                        ?>
                            <input name="compleate" type="checkbox" class="form-check-input" value="1">
                        <?php
                            endif;
                        ?>
                        
                        <span>Task completed</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body form-group">
        <div class="row">
            <div class="col-3">
                <div class="user_name">
                    <span class="info">Name:</span>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="<?=$task['name']?>">
                </div>
                <div class="user_email">
                    <span class="info">E-mail:</span>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" value="<?=$task['email']?>">
                </div>
            </div>
            <div class="col">
                <span class="info">Task:</span>
                <textarea class="form-control" name="task" rows="3"><?=$task['task']?></textarea>
                <button id="task_submit" type="submit" class="btn btn-success">Edit</button>
            </div>
        </div>
    </div>
</form>
<?php endforeach;?>

<?=$pagination?>