<div id="login" class="card">
     <div class="card-body">
     <form method="post" action="<?=Sys\Router::getURI()?>">
        <div class="error text-danger"><?=\Sys\Response::isset($errors["valid"])?></div>
        <div class="form-group">
            <label>Email address</label>
            <input name="login" type="text" class="form-control" value="<?=\Sys\Response::post("login")?>">
            <div class="error text-danger"><?=\Sys\Response::isset($errors["login"])?></div>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="pass" type="password" class="form-control"">
            <div class="error text-danger"><?=\Sys\Response::isset($errors["pass"])?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
</div>